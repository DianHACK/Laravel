<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ControllerBarang
{
    public function barang()
{
    $barang = Barang::with(['kategori', 'rak'])->latest()->get();

    return view('barang.index', compact('barang'));
}

public function create()
{
    $kategoris = Kategori::latest()->get();
    $raks = Rak::latest()->get();

    return view('barang.create', compact('kategoris', 'raks'));
}

public function edit($id)
{
    $barang = Barang::findOrFail($id);
    $kategoris = Kategori::latest()->get();
    $raks = Rak::latest()->get();

    return view('barang.edit', compact('barang', 'kategoris', 'raks'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|min:3',
            'id_kategori'  => 'required',
            'id_rak'       => 'required',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|numeric|min:0',
            'expired_date' => 'nullable|date',
            'deskripsi'    => 'nullable',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('barang', 'public');
        }

        Barang::create([
            'nama_barang'  => $request->nama_barang,
            'id_kategori'  => $request->id_kategori,
            'id_rak'       => $request->id_rak,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'expired_date' => $request->expired_date,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => $gambarPath,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil disimpan');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'  => 'required|min:3',
            'id_kategori'  => 'required',
            'id_rak'       => 'required',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|numeric|min:0',
            'expired_date' => 'nullable|date',
            'deskripsi'    => 'nullable',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $barang = Barang::findOrFail($id);

        $gambarPath = $barang->gambar;

        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $gambarPath = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update([
            'nama_barang'  => $request->nama_barang,
            'id_kategori'  => $request->id_kategori,
            'id_rak'       => $request->id_rak,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'expired_date' => $request->expired_date,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => $gambarPath,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id)
{
    $barang = Barang::findOrFail($id);

    if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
        Storage::disk('public')->delete($barang->gambar);
    }

    $barang->delete();

    return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
}


}
