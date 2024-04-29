<?php

namespace App\Http\Controllers;

use App\Models\Abonnements;
use App\Models\Fichier;
use App\Models\Reglements;
use App\Models\Residence;
use Illuminate\Http\Request;

class FichierController extends Controller
{


    public function get($id)
    {
        $fichier = Fichier::find($id);
        return response()->json($fichier);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'abonnements_id' => 'required'
        ]);
        if ($request->hasFile("fichier")) {
            $file = $request->file('fichier');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
            $file->move('uploads/details/', $filename);
            $formFields['path'] = $filename;
            $fichier = Fichier::create($formFields);
            return redirect()->back()->with('success', 'Fichier ajoutée avec succès');
        } else {
            return redirect()->back()->with('error', 'Fichier non ajoutée');
        }
    }


    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'abonnements_id' => 'required'
        ]);
        if ($request->hasFile("fichier")) {
            $fichier = Fichier::find($id);
            $file = $request->file('fichier');
            if (file_exists('uploads/details/' . $fichier->path) && $file->getClientOriginalName() != $fichier->path) {
                unlink('uploads/details/' . $fichier->path);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . md5($file->getClientOriginalName()) . '.' . $extension;
                $file->move('uploads/details/', $filename);
                $formFields['path'] = $filename;
            }
            $fichier->update($formFields);
            return redirect()->back()->with('success', 'Fichier modifiée avec succès');
        } else {
            return redirect()->back()->with('error', 'Fichier non modifiée');
        }
    }

    public function destroy($id)
    {
        $fichier = Fichier::find($id);
        if (file_exists('uploads/details/' . $fichier->path)) {
            unlink('uploads/details/' . $fichier->path);
        }
        $fichier->delete();
        return redirect()->back()->with('success', 'Fichier supprimée avec succès');
    }
}
