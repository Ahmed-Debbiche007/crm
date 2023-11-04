<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etage;
use App\Models\Residence;

class EtagesController extends Controller
{
    public function index()
    {
        $etages = Etage::with('building')->get();
        $residences = Residence::all();
        return view('pages.etages.table',['etages' => $etages, 'residences' => $residences]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            'residence_id' => ['required', 'exists:residences,id'],
            'number' => ['required','numeric'],
        ]);

        $etage = Etage::create($formFileds);
        return redirect()->route('etages')->with('success', 'Etage saved!');
    }

    public function get($id){
        $etage = Etage::findOrFail($id);
        return response()->json($etage);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'residence_id' => ['required', 'exists:residences,id'],
            'number' => ['required','numeric'],
        ]);

        $etage = Etage::findOrFail($id);
        $etage->update($formFileds);
        return redirect()->route('etages')->with('success', 'Etage updated!');
    }

    public function destroy($id)
    {
        $etage = Etage::findOrFail($id);
        $etage->delete();
        return redirect()->route('etages')->with('success', 'Etage deleted!');
    }
}
