<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Parking;
use App\Models\Residence;
use Illuminate\Http\Request;

class ParkingsController extends Controller
{
    public function index(Request $request)
    {
        $parkings = Parking::with('client', 'residence')->orderBy("created_at", "desc")->get();
        $residence = request('res');
        if ($residence) {
            $parkings = Parking::with('client', 'residence')->where('residence_id', $residence)->get();
        }
        $residences = Residence::with('etage', 'etage.appart', 'etage.appart.client', 'cellier')->get();
        $clients = Client::all();
        return view('pages.parkings.table', [
            'parkings' => $parkings,
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
            'etage_id' => ['nullable', 'exists:etages,id'],
            'appart_id' => ['nullable'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string']

        ]);

        $parking = Parking::create($formFileds);
        return redirect()->back()->with('success', 'Parking saved!');
    }

    public function get($id)
    {
        $parking = Parking::with('client')->findOrFail($id);
        return response()->json($parking);
    }



    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'etage_id' => ['nullable', 'exists:etages,id'],
            'appart_id' => ['nullable'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string']
        ]);
        
        $parking = Parking::findOrFail($id);
        $parking->update($formFileds);
        
        return redirect()->back()->with('success', 'Parking updated!');
    }

    public function destroy($id)
    {
        $parking = Parking::findOrFail($id);
        $parking->delete();
        return redirect()->back()->with('success', 'Parking deleted!');
    }
}
