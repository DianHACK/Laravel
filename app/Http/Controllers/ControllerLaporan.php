<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class ControllerLaporan
{
    public function index(Request $request)
    {
        $query = Penjualan::with('user')->orderBy('tanggal', 'desc');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal)
                  ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $laporans = $query->get();

        $totalTransaksi = $laporans->count();
        $totalPendapatan = $laporans->sum('total');

        return view('laporan.index', compact(
            'laporans',
            'totalTransaksi',
            'totalPendapatan'
        ));
    }

    public function detail($id)
    {
        $penjualan = Penjualan::with(['detail.barang', 'user'])->findOrFail($id);

        return view('laporan.detail', compact('penjualan'));
    }
}
