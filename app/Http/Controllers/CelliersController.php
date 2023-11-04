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
        $celliers = Cellier::with('client', 'residence')->get();
        $residences = Residence::all();
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
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
        ]);

        $cellier = Cellier::create($formFileds);
        return redirect()->route('celliers')->with('success', 'cellier saved!');
    }

    public function get($id)
    {
        $cellier = Cellier::findOrFail($id);
        return response()->json($cellier);
    }



    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
        ]);

        $cellier = Cellier::findOrFail($id);
        $cellier->update($formFileds);
        return redirect()->route('celliers')->with('success', 'cellier updated!');
    }

    public function destroy($id)
    {
        $cellier = Cellier::findOrFail($id);
        $cellier->delete();
        return redirect()->route('celliers')->with('success', 'cellier deleted!');
    }
}
