<?php

namespace App\Http\Controllers;

use App\Models\Appart;
use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\Etage;
use App\Models\Residence;

class ChargesController extends Controller
{
    public function index()
    {
        $charges = [];
        $etage = Etage::with('appart.charge.client','appart','appart.charge','appart.etage','appart.client','building')->get();
        $residence = request('res');
        $et = request('etage');
        $appart = request('appart');
        if ($residence) {
            $etage = Etage::with('appart','appart.charge','appart.etage','appart.client','building')->where('residence_id',$residence)->get();
        }
        if ($et) {
            $etage = Etage::with('appart','appart.charge','appart.etage','appart.client','building')->where('id',$et)->get();
        }
        if ($appart){
            $etage = Appart::with('charge')->where('id',$appart)->get();
            foreach ($etage as $appart) {
                foreach ($appart->charge as $charge) {
                    array_push($charges, $charge);
                }
            }
        }else{

            foreach($etage as $et){
                foreach($et->appart as $appart){
                    foreach($appart->charge as $charge){
                        array_push($charges,$charge);
                    }
                }
            }
        }
        $residences = Residence::with(
            'etage',
            'etage.appart',
        )->get();

        return view('pages.charges.table', [
            'charges' => $charges,
            'residences' => $residences,
        ]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            'sonede' => ['nullable', 'numeric'],
            'syndic' => ['nullable', 'numeric'],
            'avocat' => ['nullable', 'numeric'],
            'contrat' => ['nullable', 'numeric'],
            'foncier' => ['nullable', 'numeric'],
            'appart_id' => ['required', 'exists:apparts,id'],

        ]);

        $formFileds['client_id'] = Appart::findOrFail($formFileds['appart_id'])->client_id;

        $charge = Charge::create($formFileds);
        return redirect()->back()->with('success', 'Charge saved!');
    }

    public function get($id)
    {
        $charge = Charge::findOrFail($id);
        return response()->json($charge);
    }


    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'sonede' => ['nullable', 'numeric'],
            'syndic' => ['nullable', 'numeric'],
            'avocat' => ['nullable', 'numeric'],
            'contrat' => ['nullable', 'numeric'],
            'foncier' => ['nullable', 'numeric'],
            'appart_id' => ['required', 'exists:apparts,id'],
        ]);
        $formFileds['client_id'] = Appart::findOrFail($formFileds['appart_id'])->client_id;
        $charge = Charge::findOrFail($id);
        $charge->update($formFileds);
        return redirect()->back()->with('success', 'Charge updated!');
    }

    public function destroy($id)
    {
        $charge = Charge::findOrFail($id);
        $charge->delete();
        return redirect()->back()->with('success', 'Charge deleted!');
    }
}
