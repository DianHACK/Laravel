<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ControllerUser
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,kasir',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        LogAktivitas::catat(
            'Tambah User',
            'User Management',
            'Menambahkan user baru: ' . $user->name . ' sebagai ' . $user->role
        );

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role'     => 'required|in:admin,kasir',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        LogAktivitas::catat(
            'Edit User',
            'User Management',
            'Mengedit data user: ' . $user->name
        );

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return back()->with('error', 'Akun yang sedang login tidak boleh dihapus');
        }

        $user = User::findOrFail($id);

        $namaUser = $user->name;

        $user->delete();

        LogAktivitas::catat(
            'Hapus User',
            'User Management',
            'Menghapus user: ' . $namaUser
        );

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
