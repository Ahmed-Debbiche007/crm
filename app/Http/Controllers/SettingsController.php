<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        return view('pages.settings.index', [
            'settings' => $settings
        ]);
    }



    public function update(Request $request)
    {
        $formFields = $request->validate([
            'amount' => 'required',
        ]);
        $settings = Settings::first();
        $settings->update($formFields);
        return redirect()->back()->with('success', 'Paramèrtes modifiée avec succès');
    }
}
