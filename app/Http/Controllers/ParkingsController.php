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
        $parkings = Parking::with('client', 'residence')->get();
        $residence = request('res');
        if($residence){
            $parkings = Parking::with('client', 'residence')->where('residence_id', $residence)->get();
        }
        $residences = Residence::all();
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
            'number' => ['required', 'string'],

        ]);

        $parking = Parking::create($formFileds);
        return redirect()->back()->with('success', 'Parking saved!');
    }

    public function get($id)
    {
        $parking = Parking::findOrFail($id);
        return response()->json($parking);
    }



    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'residence_id' => ['required', 'exists:residences,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'number' => ['required', 'string'],
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
