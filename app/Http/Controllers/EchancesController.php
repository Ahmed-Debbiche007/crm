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
            'date_avance' => ['required', 'date'],
            'amount_avance' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'date_promesse_livre' => ['nullable', 'date'],
            'date_promesse_legal' => ['nullable', 'date'],
            'date_contrat_livre' => ['nullable', 'date'],
            'date_contrat_enregistre' => ['nullable', 'date']
        ]);
        $formFileds['client_id'] = Appart::findOrFail($formFileds['appart_id'])->client_id;
        $echance = Echance::create($formFileds);
        $i = 0;
        if ($request->hasFile("promesse")) {
            $file = $request->file('promesse');
            $extension = $file->getClientOriginalExtension();
            $filename = $i . time() . $i . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $echance->promesse = 'uploads/echanciers/' . $filename;
            $echance->save();
            $i++;
        }
        $i = 0;
        if ($request->hasFile("preuve_avance")) {
            $file = $request->file('preuve_avance');
            $extension = $file->getClientOriginalExtension();
            $filename = $i . time() . $i . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $echance->preuve_avance = 'uploads/echanciers/' . $filename;
            $echance->save();
            $i++;
        }
        $i = 0;
        if ($request->hasFile("contrat")) {
            $file = $request->file('contrat');
            $extension = $file->getClientOriginalExtension();
            $filename = $i . time() . $i . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $echance->contrat = 'uploads/echanciers/' . $filename;
            $echance->save();
            $i++;
        }
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
            'date_avance' => ['required', 'date'],
            'amount_avance' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'date_promesse_livre' => ['nullable', 'date'],
            'date_promesse_legal' => ['nullable', 'date'],
            'date_contrat_livre' => ['nullable', 'date'],
            'date_contrat_enregistre' => ['nullable', 'date']
        ]);
        $formFileds['client_id'] = Appart::findOrFail($formFileds['appart_id'])->client_id;
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
        $i = 0;
        if ($request->hasFile("promesse")) {
            $file = $request->file('promesse');
            $extension = $file->getClientOriginalExtension();
            $filename = $i . time() . $i . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $echance->promesse = 'uploads/echanciers/' . $filename;
            $echance->save();
            $i++;
        }
        $i = 0;
        if ($request->hasFile("preuve_avance")) {
            $file = $request->file('preuve_avance');
            $extension = $file->getClientOriginalExtension();
            $filename = $i . time() . $i . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $echance->preuve_avance = 'uploads/echanciers/' . $filename;
            $echance->save();
            $i++;
        }
        $i = 0;
        if ($request->hasFile("contrat")) {
            $file = $request->file('contrat');
            $extension = $file->getClientOriginalExtension();
            $filename = $i . time() . $i . '.' . $extension;
            $file->move('uploads/echanciers/', $filename);
            $echance->contrat = 'uploads/echanciers/' . $filename;
            $echance->save();
            $i++;
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
