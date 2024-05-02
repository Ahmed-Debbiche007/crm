<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('app', '!=', 0)->get();
        return view('pages.users.index', ['users' => $users]);
    }

    public function store(User $user)
    {
        $form_fields = request()->validate([
            'name' => 'required',
            'lastName' => 'nullable',
            'email' => ['nullable', 'email'],
            'role' => 'required',
        ]);

        $form_fields['password'] = "password";
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName =  $file->getClientOriginalName();
            if ($file->move(public_path() . '/storage/users/', $fileName)) {
                $form_fields['image'] = $fileName;
            }
        }
        $form_fields['app'] = 1;
        $user = User::create($form_fields);
        return redirect()->back();
    }

    public function show($id = null)
    {
        if ($id == null) {
            $user = auth()->user();
            return view('pages.users.profile', ['user' => $user]);
        }
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $form_fields = request()->validate([
            'name' => 'required',
            'lastName' => 'nullable',
            'email' => ['nullable', 'email'],
            'role' => 'required',
        ]);
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName =  $file->getClientOriginalName();
            if ($file->move(public_path() . '/storage/users/', $fileName)) {
                $form_fields['image'] = $fileName;
            }
        } else {
            $form_fields['image'] = null;
        }
        $form_fields['app'] = 1;
        $user->update($form_fields);
        return redirect()->back()->with('success', 'Photo modifié avec succès');
    }

    public function updatePassword($id, Request $request)
    {
        $user = User::findOrFail($id);
        $form_fields = request()->validate([
            'old' => 'required',
            'new' => 'required',
            'new_confirmation' => 'required|same:new',
        ]);
        if (!password_verify($form_fields['old'], $user->password)) {
            return redirect()->back()->withErrors(['old' => 'Mot de passe incorrect']);
        }
        $form_fields['new'] = bcrypt($form_fields['new']);
        $user->password = $form_fields['new'];
        $user->save();
        return redirect()->back()->with('success', 'Mot de passe modifié avec succès');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
}
