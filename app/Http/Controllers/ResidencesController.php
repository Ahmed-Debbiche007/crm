<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
         
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);


        $residence = Residence::create($formFileds);
      
        if ($request->has("gallery")){
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i.time().$i. '.' . $extension;
                $file->move('uploads/residences/', $filename);
                $image = new Image();
                $image->path = 'uploads/residences/' . $filename;
                $image->residence_id = $residence->id;
                $image->save();
                $i++;
            }
        }
        
        $residence->save();
        return redirect()->route('residences')->with('success', 'Residence saved!');
    }

    public function get($id)
    {
        $residence = Residence::with('image')->findOrFail($id);
        return response()->json($residence);
    }

    public function show($id)
    {
        $residence = Residence::with('image','etage','etage.appart','parking','cellier')->findOrFail($id);
        $clients = Client::all();
        return view('pages.residences.details', [
            'residence' => $residence,
            'clients' => $clients
        ]);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => 'required|string|max:255',

        ]);

        $residence = Residence::findOrFail($id);
        $residence->update($formFileds);
        $images = Image::where('residence_id', $residence->id)->get();
        foreach ($images as $image) {
            //delete old image
            if (file_exists($image->path)) {
                unlink($image->path);
            }
            $image->delete();
        }
        if ($request->has("gallery")){
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i.time().$i. '.' . $extension;
                $file->move('uploads/residences/', $filename);
                $image = new Image();
                $image->path = 'uploads/residences/' . $filename;
                $image->residence_id = $residence->id;
                $image->save();
                $i++;
            }
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
