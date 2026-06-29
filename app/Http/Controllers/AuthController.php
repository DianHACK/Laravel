<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            LogAktivitas::catat(
                'Login',
                'Auth',
                'User berhasil login ke sistem'
            );

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kasir',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout(Request $request)
    {
        LogAktivitas::catat(
            'Logout',
            'Auth',
            'User keluar dari sistem'
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
