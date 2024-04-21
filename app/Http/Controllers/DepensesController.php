<?php

namespace App\Http\Controllers;

use App\Models\Depenses;
use Illuminate\Http\Request;

class DepensesController extends Controller
{
    public function index()
    {
        $depenses = Depenses::all();
        return view('pages.depenses.table', [
            'depenses' => $depenses
        ]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'libelle' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'residence_id' => 'required'
        ]);
        $depense = Depenses::create($formFields);
        return redirect()->back()->with('success', 'Depense ajoutée avec succès');
    }

    public function get($id)
    {
        $depense = Depenses::find($id);
        return response()->json($depense);
    }



    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'libelle' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'residence_id' => 'required'
        ]);
        $depense = Depenses::find($id);
        $depense->update($formFields);
        return redirect()->back()->with('success', 'Depense modifiée avec succès');
    }

    public function destroy($id)
    {
        $depense = Depenses::find($id);
        $depense->delete();
        return redirect()->back()->with('success', 'Depense supprimée avec succès');
    }
}
