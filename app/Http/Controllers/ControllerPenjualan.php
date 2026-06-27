<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPenjualan
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $barangs = Barang::with(['kategori', 'rak'])
            ->where('stok', '>', 0)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama_barang', 'like', '%' . $keyword . '%')
                    ->orWhereHas('kategori', function ($kategori) use ($keyword) {
                        $kategori->where('nama_kategori', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('rak', function ($rak) use ($keyword) {
                        $rak->where('nama_rak', 'like', '%' . $keyword . '%');
                    });
                });
            })
            ->orderBy('nama_barang', 'asc')
            ->get();

        return view('penjualan.index', compact('barangs', 'keyword'));
    }

    public function tambahKeranjang(Request $request, int $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($id);

        $hargaAsli = $barang->harga;
        $diskon = $barang->diskon ?? 0;
        $hargaDiskon = $hargaAsli - ($hargaAsli * $diskon / 100);

        if ($request->jumlah > $barang->stok) {
            return back()->with('error', 'Jumlah beli melebihi stok barang');
        }

        $keranjang = Keranjang::where('id_user', Auth::id())
            ->where('id_barang', $barang->id)
            ->first();

        if ($keranjang) {
            $jumlahBaru = $keranjang->jumlah + $request->jumlah;

            if ($jumlahBaru > $barang->stok) {
                return back()->with('error', 'Jumlah di keranjang melebihi stok barang');
            }

            $keranjang->update([
                'jumlah' => $jumlahBaru,
                'harga'  => $hargaDiskon,
            ]);
        } else {
            Keranjang::create([
                'id_user'   => Auth::id(),
                'id_barang' => $barang->id,
                'jumlah'    => $request->jumlah,
                'harga'     => $hargaDiskon,
            ]);
        }

        return redirect()->route('keranjang.index')
            ->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }
}
