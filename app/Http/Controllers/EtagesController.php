<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Etage;
use App\Models\Residence;

class EtagesController extends Controller
{
    public function index(Request $request)
    {

        $etages = Etage::with('building')->orderBy("created_at","desc")->get();
        $residence = request('res');
        if ($residence) {
            $etages = Etage::where('residence_id', $residence)->get();
        }
        $residences = Residence::all();
        return view('pages.etages.table', ['etages' => $etages, 'residences' => $residences]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            'residence_id' => ['required', 'exists:residences,id'],
            'name' => ['required', 'string'],
        ]);

        $etage = Etage::create($formFileds);
        if ($request->hasFile("plan")) {
            $file = $request->file('plan');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/residences/', $filename);
            $etage->plan = 'uploads/residences/' . $filename;
            list($width, $height) = getimagesize($etage->plan);
            $etage->hplan = $height;
            $etage->wplan = $width;
            $etage->save();
        }

        return redirect()->back()->with('success', 'Etage saved!');
    }

    public function get($id)
    {
        $etage = Etage::with('appart', 'appart.charge', 'appart.etage', 'appart.client', 'building')->findOrFail($id);
        return response()->json($etage);
    }

    public function show($id)
    {
        $etage = Etage::with('appart', 'appart.charge', 'appart.etage', 'appart.client', 'building')->findOrFail($id);
        $clients = Client::all();
        $residences = Residence::with(
            'etage',
            'etage.appart',
        )->get();
        if (str_contains(strtolower($etage->name), 'sol')) {
            
            return view('pages.etages.soussol', ['etage' => $etage, 'residences' => $residences, 'clients' => $clients]);
        }
        return view('pages.etages.show', ['etage' => $etage, 'residences' => $residences, 'clients' => $clients]);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'residence_id' => ['required', 'exists:residences,id'],
            'name' => ['required', 'string'],
        ]);

        $etage = Etage::findOrFail($id);
        $etage->update($formFileds);
        if (file_exists($etage->plan)) {
            unlink($etage->plan);
        }
        if ($request->hasFile("plan")) {
            $file = $request->file('plan');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/residences/', $filename);
            $etage->plan = 'uploads/residences/' . $filename;
            list($width, $height) = getimagesize($etage->plan);
            $etage->hplan = $height;
            $etage->wplan = $width;
            $etage->save();
        }
        return redirect()->back()->with('success', 'Etage updated!');
    }

    public function destroy($id)
    {
        $etage = Etage::findOrFail($id);
        $etage->delete();
        return redirect()->back()->with('success', 'Etage deleted!');
    }
}
