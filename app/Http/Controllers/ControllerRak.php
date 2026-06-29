<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class ControllerRak 
{
    public function index()
    {
        $raks = Rak::orderBy('id', 'desc')->get();

        return view('rak.index', compact('raks'));
    }

    public function create()
    {
        return view('rak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|min:2',
            'deskripsi' => 'nullable',
        ]);

        $rak = Rak::create([
            'nama_rak' => $request->nama_rak,
            'deskripsi' => $request->deskripsi,
        ]);

        LogAktivitas::catat(
            'Tambah Rak',
            'Rak',
            'Menambahkan rak baru: ' . $rak->nama_rak
        );

        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan');
    }

    public function edit($id)
    {
        $rak = Rak::findOrFail($id);

        return view('rak.edit', compact('rak'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rak' => 'required|min:2',
            'deskripsi' => 'nullable',
        ]);

        $rak = Rak::findOrFail($id);

        $rak->update([
            'nama_rak' => $request->nama_rak,
            'deskripsi' => $request->deskripsi,
        ]);

        LogAktivitas::catat(
            'Edit Rak',
            'Rak',
            'Mengedit data rak: ' . $rak->nama_rak
        );

        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);

        $namaRak = $rak->nama_rak;

        $rak->delete();

        LogAktivitas::catat(
            'Hapus Rak',
            'Rak',
            'Menghapus rak: ' . $namaRak
        );

        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus');
    }
}
