<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Echance;
use App\Models\Residence;

class EchancesController extends Controller
{
    public function index()
    {
        $echances = Echance::with(
            'appart',
            'appart.etage',
            'appart.etage.building',
        )->get();
        $residences = Residence::with(
            'etage',
            'etage.appart',
        )->get();
        return view('pages.echances.table',[
            'echances' => $echances,
            'residences' => $residences,
        ]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            'appart_id' => ['required', 'exists:apparts,id'],
            'type' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'date_avance' => ['required', 'date'],
            'amount_avance' => ['required', 'numeric'],
            'payed' => ['required', 'boolean'],
        ]);

        $formFileds['date'] = date('Y-m-d');

        $echance = Echance::create($formFileds);
        return redirect()->route('echances')->with('success', 'Echance saved!');
    }

    public function get($id)
    {
        $echance = Echance::findOrFail($id);
        return response()->json($echance);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'appart_id' => ['required', 'exists:apparts,id'],
            'type' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'date_avance' => ['required', 'date'],
            'amount_avance' => ['required', 'numeric'],
            'payed' => ['required', 'boolean'],
        ]);

        $echance = Echance::findOrFail($id);
        $echance->update($formFileds);
        return redirect()->route('echances')->with('success', 'Echance updated!');
    }

    public function destroy($id)
    {
        $echance = Echance::findOrFail($id);
        $echance->delete();
        return redirect()->route('echances')->with('success', 'Echance deleted!');
    }
}
