<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerBarangTerlaris 
{
    public function index(Request $request)
    {
        $query = PenjualanDetail::select(
                'penjualan_detail.id_barang',
                DB::raw('SUM(penjualan_detail.jumlah) as total_terjual'),
                DB::raw('SUM(penjualan_detail.subtotal) as total_pendapatan')
            )
            ->join('penjualan', 'penjualan_detail.id_penjualan', '=', 'penjualan.id')
            ->with('barang')
            ->groupBy('penjualan_detail.id_barang')
            ->orderByDesc('total_terjual');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereDate('penjualan.tanggal', '>=', $request->tanggal_awal)
                  ->whereDate('penjualan.tanggal', '<=', $request->tanggal_akhir);
        }

        $barangTerlaris = $query->get();

        $chartLabels = $barangTerlaris->take(10)->map(function ($item) {
            return $item->barang->nama_barang ?? 'Barang tidak ditemukan';
        });

        $chartData = $barangTerlaris->take(10)->pluck('total_terjual');

        return view('laporan.barang-terlaris', compact(
            'barangTerlaris',
            'chartLabels',
            'chartData'
        ));
    }
}
