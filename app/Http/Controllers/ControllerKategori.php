<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class ControllerKategori 
{
    public function index()
    {
        $kategoris = Kategori::orderBy('id', 'desc')->get();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|min:3',
            'deskripsi' => 'nullable',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        LogAktivitas::catat(
            'Tambah Kategori',
            'Kategori',
            'Menambahkan kategori: ' . $kategori->nama_kategori
        );

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|min:3',
            'deskripsi' => 'nullable',
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        LogAktivitas::catat(
            'Edit Kategori',
            'Kategori',
            'Mengedit kategori: ' . $kategori->nama_kategori
        );

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        $namaKategori = $kategori->nama_kategori;

        $kategori->delete();

        LogAktivitas::catat(
            'Hapus Kategori',
            'Kategori',
            'Menghapus kategori: ' . $namaKategori
        );

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
