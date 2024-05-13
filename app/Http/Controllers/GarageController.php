<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Garage;
use App\Models\Residence;
use Illuminate\Http\Request;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::with('client', 'residence')->orderBy("created_at","desc")->get();
        $residence = request('res');
        if($residence){
            $garages = Garage::with('client', 'residence')->where('residence_id', $residence)->get();
        }
        $residences = Residence::with('etage','etage.appart','etage.appart.client','garage')->get();
        $clients = Client::all();
        return view('pages.garages.table', [
            'garages' => $garages,
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
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'etage_id' => ['nullable', 'exists:etages,id'],
            'appart_id' => ['nullable'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string'],
        ]);

        $garage = Garage::create($formFileds);
        return redirect()->back()->with('success', 'garage saved!');
    }

    public function get($id)
    {
        $garage = Garage::with('client')->findOrFail($id);
        return response()->json($garage);
    }



    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'surface' => ['nullable', 'numeric'],
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'etage_id' => ['nullable', 'exists:etages,id'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string'],
            'appart_id' => ['nullable']
        ]);

        $garage = Garage::findOrFail($id);
        $garage->update($formFileds);
        return redirect()->back()->with('success', 'garage updated!');
    }

    public function destroy($id)
    {
        $garage = Garage::findOrFail($id);
        $garage->delete();
        return redirect()->back()->with('success', 'garage deleted!');
    }
}
