<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\Rule;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('pages.clients.table', [
            'clients' => $clients,
        ]);
    }

    public function store(Request $request)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255', 'regex:/^(\+216\d{8}|\d{8})$/'],
            'cin' => ['nullable', 'string', 'max:255', 'regex:/^\d{8}$/'],
            'email' => ['nullable', 'email'],
            'type' => ['nullable', 'integer'],
            'comments' => ['nullable', 'string'],
        ]);

        $client = Client::create($formFileds);
        return redirect()->back()->with('success', 'Client saved!');
    }

    public function get($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255', 'regex:/^(\+216\d{8}|\d{8})$/'],
            'cin' => ['nullable', 'string', 'max:255', 'regex:/^\d{8}$/'],
            'email' => ['nullable', 'email'],
            'type' => ['nullable', 'integer'],
            'comments' => ['nullable', 'string'],
        ]);

        $client = Client::findOrFail($id);
        $client->update($formFileds);
        return redirect()->back()->with('success', 'Client updated!');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->back()->with('success', 'Client deleted!');
    }
}
