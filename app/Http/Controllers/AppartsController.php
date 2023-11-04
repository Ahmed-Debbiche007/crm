<?php

namespace App\Http\Controllers;

use App\Models\Appart;
use App\Models\Client;
use App\Models\Etage;
use App\Models\Residence;
use Illuminate\Http\Request;

class AppartsController extends Controller
{
    public function index()
    {
        $apparts = Appart::with(
            'etage',
            'etage.building',
            'client',

        )->get();
        $etages = Etage::all();
        $residences = Residence::with(
            'etage',
            'parking',
            'cellier'
        )->get();
        $clients = Client::all();
        return view('pages.apparts.table', ['apparts' => $apparts, 'etages' => $etages, 'residences' => $residences, 'clients' => $clients]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'etage_id' => ['required', 'exists:etages,id'],
            'type' => ['required', 'integer'],
            'surface' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bs' => ['required', 'integer'],
            'comments' => ['required', 'string'],
        ]);

        $appart = Appart::create($formFileds);
        return redirect()->route('apparts')->with('success', 'Appart saved!');
    }

    public function get($id)
    {
        $appart = Appart::findOrFail($id);
        return response()->json($appart);
    }


    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'etage_id' => ['required', 'exists:etages,id'],
            'type' => ['required', 'integer'],
            'surface' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bs' => ['required', 'integer'],
            'comments' => ['required', 'string'],
        ]);

        $appart = Appart::findOrFail($id);
        $appart->update($formFileds);
        return redirect()->route('apparts')->with('success', 'Appart updated!');
    }

    public function destroy($id)
    {
        $appart = Appart::findOrFail($id);
        $appart->delete();
        return redirect()->route('apparts')->with('success', 'Appart deleted!');
    }
}
