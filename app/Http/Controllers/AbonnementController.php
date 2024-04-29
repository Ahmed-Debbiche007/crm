<?php

namespace App\Http\Controllers;

use App\Models\Abonnements;
use App\Models\Appart;
use App\Models\Depenses;
use App\Models\Reglements;
use App\Models\Residence;
use App\Models\Settings;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function index()
    {
        $apparts = Appart::with('client', 'abonnements', 'abonnements.reglements', 'etage', 'etage.building')->whereHas('etage.building', function ($query) {
            $query->where('id', 2);
        })->get();
        // get query params
        $query = request()->query();

        if (isset($query['annee'])) {
            $annee = $query['annee'];
            
            foreach ($apparts as $appart) {
                $appart->abonnements = $appart->abonnements->reject(function ($abonnement) use ($annee) {
                    return $abonnement->annee != $annee;
                });
            }
        }
        if (isset($query['client'])) {

            $clientId = $query['client'];
            $apparts = $apparts->filter(function ($appart) use ($clientId) {
                return $appart->client != null && $appart->client->id == $clientId;
            });
        }
        $clients = [];
        foreach ($apparts as $appart) {
            if ($appart->client != null) {
                $clients[] = $appart->client;
            }
        }

        usort($clients, function ($a, $b) {
            return $a->name <=> $b->name;
        });
        $settings = Settings::first();
        $abonnements = Abonnements::with('appart', 'appart.etage', 'appart.client', 'appart.etage.building', 'reglements')->get();
        $residences = Residence::with('etage', 'etage.appart', 'etage.appart.client', 'cellier')->where('id', 2)->get();
        return view('pages.abonnements.table', [
            'abonnements' => $abonnements,
            'residences' => $residences,
            'apparts' => $apparts,
            'settings' => $settings,
            'clients' => $clients
        ]);
    }

    public function show($id)
    {
        $abonnement = Abonnements::with('appart', 'appart.etage', 'appart.etage.building', 'reglements')->find($id);
        return view('pages.abonnements.show', [
            'abonnement' => $abonnement
        ]);
    }

    public function store(Request $request)
    {

        $formFields = $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'appart_id' => 'required',
            'annee' => 'required'
        ]);

        $abonnement = Abonnements::where('appart_id', $formFields['appart_id'])->where('annee', $formFields['annee'])->first();
        if ($abonnement == null) {
            $settings = Settings::first();
            $abonnement = new Abonnements();
            $abonnement->amount = $settings->amount;
            $abonnement->date = $formFields['date'];
            $abonnement->appart_id = $formFields['appart_id'];
            $abonnement->annee = $formFields['annee'];
            $abonnement->save();
        }
        $reglement = new Reglements();
        $reglement->amount = $formFields['amount'];
        $reglement->date = $formFields['date'];
        $reglement->abonnements_id = $abonnement->id;
        $reglement->save();

        return redirect()->back()->with('success', 'Abonnement ajoutée avec succès');
    }

    public function get($id)
    {
        $abonnements = Abonnements::find($id);
        return response()->json($abonnements);
    }



    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'appart_id' => 'required'
        ]);
        $abonnement = Abonnements::find($id);
        $abonnement->amount = $formFields['amount'];
        $abonnement->date = $formFields['date'];
        $abonnement->appart_id = $formFields['appart_id'];
        $abonnement->save();
        return redirect()->route('abonnements.index')->with('success', 'Abonnement modifiée avec succès');
    }

    public function destroy($id)
    {
        $abonnement = Abonnements::find($id);
        $abonnement->delete();
        return redirect()->route('depenses.index')->with('success', 'Depense supprimée avec succès');
    }
}
