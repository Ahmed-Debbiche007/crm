<?php

namespace App\Http\Controllers;

use App\Models\Appart;
use Illuminate\Http\Request;
use App\Models\Echance;
use App\Models\Etage;
use App\Models\Residence;

class EchancesController extends Controller
{
    public function index()
    {
        $echances = [];
        $etage = Etage::with('appart.echance.client','appart', 'appart.echance', 'appart.etage', 'appart.client', 'building')->get();
        $residence = request('res');
        $et = request('etage');
        $appart = request('appart');
        if ($residence) {
            $etage = Etage::with('appart', 'appart.echance', 'appart.etage', 'appart.client', 'building')->where('residence_id', $residence)->get();
        }
        if ($et) {
            $etage = Etage::with('appart', 'appart.echance', 'appart.etage', 'appart.client', 'building')->where('id', $et)->get();
        }
        if ($appart) {
            $etage = Appart::with('echance')->where('id', $appart)->get();
            foreach ($etage as $appart) {
                foreach ($appart->echance as $echance) {
                    array_push($echances, $echance);
                }
            }
        } else {

            foreach ($etage as $et) {
                foreach ($et->appart as $appart) {
                    foreach ($appart->echance as $echance) {
                        array_push($echances, $echance);
                    }
                }
            }
        }
        usort($echances, function ($a, $b) {
            return $a->created_at < $b->created_at;
        });
        $residences = Residence::with(
            'etage',
            'etage.appart',
        )->get();
        return view('pages.echances.table', [
            'echances' => $echances,
            'residences' => $residences,
        ]);
    }

    public function store(Request $request)
    {
        
        $formFileds = $request->validate([
            'appart_id' => ['required', 'exists:apparts,id'],
            'date_avance' => ['nullable', 'date'],
            'amount_avance' => ['nullable', 'numeric'],
            'modalite' =>['required', 'string'],
            'date' => ['nullable', 'date'],
            'date_promesse_livre' => ['nullable', 'date'],
            'date_promesse_legal' => ['nullable', 'date'],
            'date_contrat_livre' => ['nullable', 'date'],
            'date_contrat_enregistre' => ['nullable', 'date'],
            'date_acte_livre'=> ['nullable', 'date'],
            'date_acte_enreg'=> ['nullable', 'date'],
        ]);
        $appart = Appart::findOrFail($formFileds['appart_id']);
        if ($formFileds['amount_avance'] == null || $formFileds['amount_avance'] == "") {
            $formFileds['amount_avance'] = 0;
        } 
        
        $formFileds['client_id']=$appart->client_id;
        $formFileds['price']=$appart->price;
        // get the latest id 
        $latest = Echance::orderBy('id', 'desc')->first();
        if($latest){
            $formFileds['id'] = intval($latest->id) + 1;
        }else{
            $formFileds['id'] = 1;
        }
        $i = 0;
        if ($request->hasFile("promesse")) {
            $file = $request->file('promesse');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['promesse'] = 'uploads/echanciers/' . $filename;
            $i++;
        }
        $i = 0;
        if ($request->hasFile("preuve_avance")) {
            $file = $request->file('preuve_avance');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['preuve_avance'] = 'uploads/echanciers/' . $filename;
            $i++;
        }
        $i = 0;
        if ($request->hasFile("contrat")) {
            $file = $request->file('contrat');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['contrat'] = 'uploads/echanciers/' . $filename;
            $i++;
        }
        $j = 0;
        if ($request->hasFile("acte")) {
            $file = $request->file('acte');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['acte'] = 'uploads/echanciers/' . $filename;
            $i++;
            $j++;
        }
        
        $echance = Echance::create($formFileds);
        
        return redirect()->back()->with('success', 'Echance saved!');
    }

    public function get($id)
    {
        $echance = Echance::findOrFail($id);
        return response()->json($echance);
    }

    public function show ($id)
    {
        $echance = Echance::with('client','echeance', 'appart', 'appart.client','appart.etage','appart.etage.building' )->findOrFail($id);
        $residences = Residence::with(
            'etage',
            'etage.appart',
        )->get();
        return view('pages.echances.show', ['echance' => $echance,'residences' => $residences,]);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'appart_id' => ['required', 'exists:apparts,id'],
            'date_avance' => ['nullable', 'date'],
            'amount_avance' => ['nullable', 'numeric'],
            'modalite' =>['required', 'string'],
            'date' => ['nullable', 'date'],
            'date_promesse_livre' => ['nullable', 'date'],
            'date_promesse_legal' => ['nullable', 'date'],
            'date_contrat_livre' => ['nullable', 'date'],
            'date_contrat_enregistre' => ['nullable', 'date'],
            'date_acte_livre'=> ['nullable', 'date'],
            'date_acte_enreg'=> ['nullable', 'date'],
        ]);
        $appart = Appart::findOrFail($formFileds['appart_id']);
        if ($formFileds['amount_avance'] == null || $formFileds['amount_avance'] == "") {
            $formFileds['amount_avance'] = 0;
        }
        $formFileds['client_id']=$appart->client_id;
        $formFileds['price']=$appart->price;
        $echance = Echance::findOrFail($id);
        if (file_exists($echance->promesse)) {
            unlink($echance->promesse);
        }
        if (file_exists($echance->preuve_avance)) {
            unlink($echance->preuve_avance);
        }
        if (file_exists($echance->contrat)) {
            unlink($echance->contrat);
        }
        if (file_exists($echance->acte)) {
            unlink($echance->acte);
        }
        $i = 0;
        if ($request->hasFile("promesse")) {
            $file = $request->file('promesse');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['promesse'] = 'uploads/echanciers/' . $filename;
            $i++;
        }
        $i = 0;
        if ($request->hasFile("preuve_avance")) {
            $file = $request->file('preuve_avance');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['preuve_avance'] = 'uploads/echanciers/' . $filename;
            $i++;
        }
        $i = 0;
        if ($request->hasFile("contrat")) {
            $file = $request->file('contrat');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['contrat'] = 'uploads/echanciers/' . $filename;
            $i++;
        }
        $j = 0;
        if ($request->hasFile("acte")) {
            $file = $request->file('acte');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $formFileds['acte'] = 'uploads/echanciers/' . $filename;
            $i++;
            $j++;
        }
        $echance->update($formFileds);
        return redirect()->back()->with('success', 'Echance updated!');
    }

    public function destroy($id)
    {
        $echance = Echance::findOrFail($id);
        $echance->delete();
        return redirect()->back()->with('success', 'Echance deleted!');
    }
}
