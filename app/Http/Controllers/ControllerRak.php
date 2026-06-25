<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class ControllerRak 
{
    public function index()
    {
        $raks = Rak::latest()->get();

        return view('rak.index', compact('raks'));
    }

    public function create()
    {
        return view('rak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak'  => 'required|min:2',
            'lokasi'    => 'nullable',
            'deskripsi' => 'nullable',
        ]);

        Rak::create([
            'nama_rak'  => $request->nama_rak,
            'lokasi'    => $request->lokasi,
            'deskripsi' => $request->deskripsi,
        ]);

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
            'nama_rak'  => 'required|min:2',
            'lokasi'    => 'nullable',
            'deskripsi' => 'nullable',
        ]);

        $rak = Rak::findOrFail($id);

        $rak->update([
            'nama_rak'  => $request->nama_rak,
            'lokasi'    => $request->lokasi,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus');
    }
}
