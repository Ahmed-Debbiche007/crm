<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etage;
use App\Models\Residence;

class EtagesController extends Controller
{
    public function index(Request $request)
    {
        
        $etages = Etage::with('building')->get();
        $residence = request('res');
        if($residence){
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
            $etage->save();
        }

        return redirect()->route('etages')->with('success', 'Etage saved!');
    }

    public function get($id)
    {
        $etage = Etage::findOrFail($id);
        return response()->json($etage);
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
            $etage->save();
        }
        return redirect()->route('etages')->with('success', 'Etage updated!');
    }

    public function destroy($id)
    {
        $etage = Etage::findOrFail($id);
        $etage->delete();
        return redirect()->route('etages')->with('success', 'Etage deleted!');
    }
}
