<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ControllerProfile
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name'  => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diganti');
    }
}
