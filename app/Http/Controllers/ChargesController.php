<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\Residence;

class ChargesController extends Controller
{
    public function index()
    {
        $charges = Charge::with(
            'appart',
            'appart.etage',
            'appart.etage.building',
        )->get();

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

        $charge = Charge::create($formFileds);
        return redirect()->route('charges')->with('success', 'Charge saved!');
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

        $charge = Charge::findOrFail($id);
        $charge->update($formFileds);
        return redirect()->route('charges')->with('success', 'Charge updated!');
    }

    public function destroy($id)
    {
        $charge = Charge::findOrFail($id);
        $charge->delete();
        return redirect()->route('charges')->with('success', 'Charge deleted!');
    }
}
