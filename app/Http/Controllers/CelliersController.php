<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\Client;
use App\Models\Residence;
use Illuminate\Http\Request;

class CelliersController extends Controller
{
    public function index()
    {
        $celliers = Cellier::with('client', 'residence')->orderBy("created_at","desc")->get();
        $residence = request('res');
        if($residence){
            $celliers = Cellier::with('client', 'residence')->where('residence_id', $residence)->get();
        }
        $residences = Residence::with('etage','etage.appart','etage.appart.client','cellier')->get();
        $clients = Client::all();
        return view('pages.celliers.table', [
            'celliers' => $celliers,
            'residences' => $residences,
            'clients' => $clients
        ]);
    }

    public function store(Request $request)
    {

        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'surface' => ['nullable', 'numeric'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string'],
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'etage_id' => ['nullable', 'exists:etages,id'],
            'appart_id' => ['nullable']
        ]);

        $cellier = Cellier::create($formFileds);
        return redirect()->back()->with('success', 'cellier saved!');
    }

    public function get($id)
    {
        $cellier = Cellier::with('client')->findOrFail($id);
        return response()->json($cellier);
    }



    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'surface' => ['nullable', 'numeric'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string'],
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'etage_id' => ['nullable', 'exists:etages,id'],
            'appart_id' => ['nullable']
        ]);

        $cellier = Cellier::findOrFail($id);
        $cellier->update($formFileds);
        return redirect()->back()->with('success', 'cellier updated!');
    }

    public function destroy($id)
    {
        $cellier = Cellier::findOrFail($id);
        $cellier->delete();
        return redirect()->back()->with('success', 'cellier deleted!');
    }
}
