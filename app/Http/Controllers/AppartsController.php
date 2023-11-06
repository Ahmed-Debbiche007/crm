<?php

namespace App\Http\Controllers;

use App\Models\Appart;
use App\Models\Client;
use App\Models\Etage;
use App\Models\Image;
use App\Models\Residence;
use Illuminate\Http\Request;

class AppartsController extends Controller
{
    public function index()
    {
        $apparts = [];
        $etage = Etage::with('appart','appart.etage','appart.client','building')->get();
        $residence = request('res');
        $et = request('etage');
        if ($residence) {
            $etage = Etage::with('appart','appart.charge','appart.etage','appart.client','building')->where('residence_id',$residence)->get();
        }
        if ($et) {
            $etage = Etage::with('appart','appart.etage','appart.client','building')->where('id',$et)->get();
        }
        foreach($etage as $et){
            foreach($et->appart as $appart){
                array_push($apparts,$appart);
            }
        }
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
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['required', 'integer'],
            'surface' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bs' => ['required', 'integer'],
            'comments' => ['required', 'string'],
        ]);

        $appart = Appart::create($formFileds);
        if ($request->has("gallery")) {
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i . time() . $i . '.' . $extension;
                $file->move('uploads/apparts/', $filename);
                $image = new Image();
                $image->path = 'uploads/apparts/' . $filename;
                $image->appart_id = $appart->id;
                $image->save();
                $i++;
            }
        }
        $appart->save();
        return redirect()->back()->with('success', 'Appart saved!');
    }

    public function get($id)
    {
        $appart = Appart::with('image')->findOrFail($id);
        return response()->json($appart);
    }

    public function show($id)
    {
        $appart = Appart::with('image', 'echance', 'charge', 'echance.client', 'charge.client','echance.echeance')->findOrFail($id);
        $etages = Etage::all();
        $residences = Residence::with(
            'etage',
            'parking',
            'cellier'
        )->get();
        $clients = Client::all();
        return view('pages.apparts.show', ['appart' => $appart,'etages' => $etages, 'residences' => $residences, 'clients' => $clients]);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'etage_id' => ['required', 'exists:etages,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['required', 'integer'],
            'surface' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bs' => ['required', 'integer'],
            'comments' => ['required', 'string'],
        ]);

        $appart = Appart::findOrFail($id);
        $appart->update($formFileds);
        $images = Image::where('appart_id', $appart->id)->get();
        foreach ($images as $image) {
            //delete old image
            if (file_exists($image->path)) {
                unlink($image->path);
            }
            $image->delete();
        }
        if ($request->has("gallery")) {
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i . time() . $i . '.' . $extension;
                $file->move('uploads/apparts/', $filename);
                $image = new Image();
                $image->path = 'uploads/apparts/' . $filename;
                $image->appart_id = $appart->id;
                $image->save();
                $i++;
            }
        }
        return redirect()->back()->with('success', 'Appart updated!');
    }

    public function destroy($id)
    {
        $appart = Appart::findOrFail($id);
        $appart->delete();
        return redirect()->back()->with('success', 'Appart deleted!');
    }
}
