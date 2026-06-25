<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerBarangCreate
{
    public function barangcreate()
    {
        return view('barang/create');
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
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        return redirect('/barang')->with('success', 'Barang berhasil disimpan');
    }
}
