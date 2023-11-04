<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Residence;

class ResidencesController extends Controller
{
    public function index()
    {
        $residences = Residence::all();
        return view('pages.residences.table', [
            'residences' => $residences
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);


        $residence = Residence::create($formFileds);
        if ($request->hasFile('logo')) {
            $logofile = $request->file('logo');
            $extension = $logofile->getClientOriginalExtension();
            $filename = $logofile->getClientOriginalName() . '.' . $extension;
            $logofile->move('uploads/residences/', $filename);
            $logo = new Image();
            $logo->path = 'uploads/residences/' . $filename;
            $logo->save();
            $residence->logo = $logo->id;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName() . '.' . $extension;
            $file->move('uploads/residences/', $filename);
            $image = new Image();
            $image->path = 'uploads/residences/' . $filename;
            $image->save();
            $residence->image = $image->id;
        }
        $residence->save();
        return redirect()->route('residences')->with('success', 'Residence saved!');
    }

    public function get($id)
    {
        $residence = Residence::with('logo', 'image')->findOrFail($id);
        return response()->json($residence);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => 'required|string|max:255',

        ]);

        $residence = Residence::findOrFail($id);
        $residence->update($formFileds);
        if ($request->hasFile('logo')) {
            $logofile = $request->file('logo');
            $extension = $logofile->getClientOriginalExtension();
            $filename = $logofile->getClientOriginalName() . '.' . $extension;
            $logofile->move('uploads/residences/', $filename);
            $logo = new Image();
            $logo->path = 'uploads/residences/' . $filename;
            $logo->save();
            $residence->logo = $logo->id;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName() . '.' . $extension;
            $file->move('uploads/residences/', $filename);
            $image = new Image();
            $image->path = 'uploads/residences/' . $filename;
            $image->save();
            $residence->image = $image->id;
        }
        $residence->save();
        return redirect()->route('residences')->with('success', 'Residence updated!');
    }

    public function destroy($id)
    {
        $residence = Residence::findOrFail($id);
        $residence->delete();
        return redirect()->route('residences')->with('success', 'Residence deleted!');
    }
}
