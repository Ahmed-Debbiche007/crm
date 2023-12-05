<?php

namespace App\Http\Controllers;

use App\Models\Echeances;
use Illuminate\Http\Request;

class EcheancesController extends Controller
{
    public function index()
    {
        return view('pages.echances.table');
    }

    public function store(Request $request)
    {
        
        $formFileds = $request->validate([
            'echance_id' =>['required', 'exists:echances,id'],
            'date' =>['required', 'date'],
            'montant' =>['required', 'numeric'],
            'payed' =>['required', 'boolean'],
            'modalite' =>['required', 'string']
        ]);
        $echance = Echeances::create($formFileds);
        return redirect()->back();
    }

    public function get($id){
        $echance = Echeances::findOrFail($id);
        return response()->json($echance);
    }

    public function update(Request $request, $id)
    {   
        $echance = Echeances::findOrFail($id);
        $formFileds = $request->validate([
            'echance_id' =>['required', 'exists:echances,id'],
            'date' =>['required', 'date'],
            'montant' =>['required', 'numeric'],
            'payed' =>['required', 'boolean'],
            'modalite' =>['required', 'string']
        ]);
        $echance->update($formFileds);
        return redirect()->back();
    }

    public function destroy( $id)
    {
        $echeance = Echeances::findOrFail($id);
        $echeance->delete();
        return redirect()->back();
    }
}
