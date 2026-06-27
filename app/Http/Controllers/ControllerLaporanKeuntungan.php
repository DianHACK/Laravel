<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerLaporanKeuntungan 
{
    public function index(Request $request)
    {
        $query = PenjualanDetail::select(
                'penjualan_detail.id_barang',
                DB::raw('SUM(penjualan_detail.jumlah) as total_terjual'),
                DB::raw('SUM(penjualan_detail.subtotal) as total_omzet'),
                DB::raw('SUM(penjualan_detail.subtotal_modal) as total_modal'),
                DB::raw('SUM(penjualan_detail.laba) as total_laba')
            )
            ->join('penjualan', 'penjualan_detail.id_penjualan', '=', 'penjualan.id')
            ->with('barang')
            ->groupBy('penjualan_detail.id_barang')
            ->orderByDesc('total_laba');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereDate('penjualan.tanggal', '>=', $request->tanggal_awal)
                  ->whereDate('penjualan.tanggal', '<=', $request->tanggal_akhir);
        }

        $laporanKeuntungan = $query->get();

        $totalOmzet = $laporanKeuntungan->sum('total_omzet');
        $totalModal = $laporanKeuntungan->sum('total_modal');
        $totalLaba = $laporanKeuntungan->sum('total_laba');

        $chartLabels = $laporanKeuntungan->take(10)->map(function ($item) {
            return $item->barang->nama_barang ?? 'Barang tidak ditemukan';
        });

        $chartData = $laporanKeuntungan->take(10)->pluck('total_laba');

        return view('laporan.keuntungan', compact(
            'laporanKeuntungan',
            'totalOmzet',
            'totalModal',
            'totalLaba',
            'chartLabels',
            'chartData'
        ));
    }
}
