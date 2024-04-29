<?php

namespace App\Http\Controllers;

use App\Models\Abonnements;
use App\Models\Reglements;
use App\Models\Residence;
use Illuminate\Http\Request;

class ReglementController extends Controller
{

    public function index($id)
    {
        $abonnements = Abonnements::with('appart','appart.etage','appart.client','appart.etage.building','reglements','fichiers')->where('id', $id)->get();
        $residences = Residence::with('etage','etage.appart','etage.appart.client','cellier')->where('id', 2)->get();
        return view('pages.reglements.table', [
            'abonnements' => $abonnements,
            'residences' => $residences
        ]);
    }
    

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'abonnement_id' => 'required'
        ]);
        $reglement = Reglements::create($formFields);
        return redirect()->route('reglements.index')->with('success', 'Reglement ajoutée avec succès');
    }

    public function get($id)
    {
        $reglement = Reglements::find($id);
        return response()->json($reglement);
    }



    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'abonnement_id' => 'required'
        ]);
        $reglement = Reglements::find($id);
        $reglement->update($formFields);
        return redirect()->back()->with('success', 'Reglement modifiée avec succès');
    }

    public function destroy($id)
    {
        $reglement = Reglements::find($id);
        $reglement->delete();
        return redirect()->back()->with('success', 'Reglement supprimée avec succès');
    }
}