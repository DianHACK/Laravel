<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControllerStokBarang 
{
    public function index(Request $request)
    {
        $query = StokBarang::with(['barang', 'user'])
            ->orderBy('tanggal', 'desc');

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->id_barang) {
            $query->where('id_barang', $request->id_barang);
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal)
                  ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $stokBarangs = $query->get();

        $barangs = Barang::orderBy('nama_barang', 'asc')->get();

        $totalMasuk = $stokBarangs->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $stokBarangs->where('jenis', 'keluar')->sum('jumlah');

        return view('stok.index', compact(
            'stokBarangs',
            'barangs',
            'totalMasuk',
            'totalKeluar'
        ));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang', 'asc')->get();

        return view('stok.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang'  => 'required|exists:barang,id',
            'jenis'      => 'required|in:masuk,keluar',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $barang = Barang::findOrFail($request->id_barang);

            $stokSebelum = $barang->stok;

            if ($request->jenis == 'masuk') {
                $stokSesudah = $stokSebelum + $request->jumlah;
            } else {
                if ($request->jumlah > $barang->stok) {
                    return back()
                        ->withInput()
                        ->with('error', 'Jumlah stok keluar melebihi stok barang yang tersedia');
                }

                $stokSesudah = $stokSebelum - $request->jumlah;
            }

            $barang->update([
                'stok' => $stokSesudah,
            ]);

            StokBarang::create([
                'id_barang'    => $barang->id,
                'id_user'      => Auth::id(),
                'jenis'        => $request->jenis,
                'jumlah'       => $request->jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'keterangan'   => $request->keterangan,
                'tanggal'      => now(),
            ]);

            DB::commit();

            return redirect()->route('stok.index')
                ->with('success', 'Data stok barang berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
