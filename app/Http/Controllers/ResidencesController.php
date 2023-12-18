<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Residence;

class ResidencesController extends Controller
{
    public function index()
    {
        $residences = Residence::all();
        return view('pages.residences.table', [
            'residences' => $residences
        ]);
    }

    public function store(Request $request)
    {

        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'nfoncier' => ['nullable', 'string', 'max:255'],
            'emplacemnt' => ['nullable', 'string', 'max:255'],
            'npermis' => ['nullable', 'string', 'max:255'],
            'detailMunicipal' => ['nullable', 'string', 'max:255'],
        ]);


        $residence = Residence::create($formFileds);
        if ($request->has("details")) {
            $i = 0;
            foreach ($request->file('details') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $file->move('uploads/residences/', $filename);
                $file = new File();
                $file->name = $filename;
                $file->path = 'uploads/residences/' . $filename;
                $file->residence_id = $residence->id;
                $file->save();
                $i++;
            }
        }


        if ($request->has("gallery")) {
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i . time() . $i . '.' . $extension;
                $file->move('uploads/residences/', $filename);
                $image = new Image();
                $image->path = 'uploads/residences/' . $filename;
                $image->residence_id = $residence->id;
                $image->save();
                $i++;
            }
        }

        $residence->save();
        return redirect()->back()->with('success', 'Residence saved!');
    }

    public function get($id)
    {
        $residence = Residence::with('image','file')->findOrFail($id);
        return response()->json($residence);
    }

    public function show($id)
    {
        $residence = Residence::with('image','file', 'etage', 'etage.appart','etage.appart.echance','etage.appart.client','etage.appart.charge', 'etage.appart.echance.echeance', 'parking', 'cellier')->findOrFail($id);
        $clients = Client::all();

        $total_echance = 0;
        $total_echeance = 0;
        $total_sonede = 0;
        $total_syndic = 0;
        $total_avocat = 0;
        $total_contrat = 0;
        $total_foncier = 0;
        foreach ($residence->etage as $etage) {
            foreach ($etage->appart as $appart) {
                foreach($appart->charge as $charge){
                    $total_sonede += $charge->sonede;
                    $total_syndic += $charge->syndic;
                    $total_avocat += $charge->avocat;
                    $total_contrat += $charge->contrat;
                    $total_foncier += $charge->foncier;

                }
                foreach ($appart->echance as $echance) {
                    $total_echance += $echance->price;
                    $total_echeance += $echance->amount_avance;
                    foreach ($echance->echeance as $echeance) {
                        if($echeance->payed == 0){
                            $total_echeance += $echeance->montant;
                        }
                    }
                }
            }
        }


        return view('pages.residences.details', [
            'residence' => $residence,
            'clients' => $clients,
            'total_echance'=>$total_echance,
            'total_echeance'=>$total_echeance,
            'total_sonede'=>$total_sonede,
            'total_syndic'=>$total_syndic,
            'total_avocat'=>$total_avocat,
            'total_contrat'=>$total_contrat,
            'total_foncier'=>$total_foncier,
        ]);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'nfoncier' => ['nullable', 'string', 'max:255'],
            'emplacemnt' => ['nullable', 'string', 'max:255'],
            'npermis' => ['nullable', 'string', 'max:255'],
            'detailMunicipal' => ['nullable', 'string', 'max:255'],
        ]);

        $residence = Residence::findOrFail($id);
        $residence->update($formFileds);
        $images = Image::where('residence_id', $residence->id)->get();
        $files = File::where('residence_id', $residence->id)->get();
        foreach ($images as $image) {
            //delete old image
            if (file_exists($image->path)) {
                unlink($image->path);
            }
            $image->delete();
        }

        foreach ($files as $file) {
            //delete old image
            if (file_exists($file->path)) {
                unlink($file->path);
            }
            $file->delete();
        }

        
        if ($request->has("details")) {
            $i = 0;
            foreach ($request->file('details') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $file->move('uploads/residences/', $filename);
                $file = new File();
                $file->name = $filename;
                $file->path = 'uploads/residences/' . $filename;
                $file->residence_id = $residence->id;
                $file->save();
                $i++;
            }
        }
        if ($request->has("gallery")) {
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i . time() . $i . '.' . $extension;
                $file->move('uploads/residences/', $filename);
                $image = new Image();
                $image->path = 'uploads/residences/' . $filename;
                $image->residence_id = $residence->id;
                $image->save();
                $i++;
            }
        }
        $residence->save();
        return redirect()->back()->with('success', 'Residence updated!');
    }

    public function destroy($id)
    {
        $residence = Residence::findOrFail($id);
        $residence->delete();
        return redirect()->back()->with('success', 'Residence deleted!');
    }
}
