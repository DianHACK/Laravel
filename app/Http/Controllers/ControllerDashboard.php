<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Rak;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ControllerDashboard
{
    public function dashboard()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalRak = Rak::count();

        $stokMenipis = Barang::where('stok', '<=', 50)->count();

        $queryPenjualan = Penjualan::query();

        if (Auth::user()->role == 'kasir') {
            $queryPenjualan->where('id_user', Auth::id());
        }

        $transaksiHariIni = (clone $queryPenjualan)
            ->whereDate('tanggal', today())
            ->count();

        $pendapatanHariIni = (clone $queryPenjualan)
            ->whereDate('tanggal', today())
            ->sum('total');

        $transaksiTerbaru = (clone $queryPenjualan)
            ->with('user')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Grafik penjualan harian 7 hari terakhir
        $grafikHarianLabels = [];
        $grafikHarianData = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);

            $grafikHarianLabels[] = $tanggal->format('d M');

            $grafikHarianData[] = (clone $queryPenjualan)
                ->whereDate('tanggal', $tanggal)
                ->sum('total');
        }

        // Grafik penjualan mingguan 4 minggu terakhir
        $grafikMingguanLabels = [];
        $grafikMingguanData = [];

        for ($i = 3; $i >= 0; $i--) {
            $awalMinggu = Carbon::now()->subWeeks($i)->startOfWeek();
            $akhirMinggu = Carbon::now()->subWeeks($i)->endOfWeek();

            $grafikMingguanLabels[] = $awalMinggu->format('d M') . ' - ' . $akhirMinggu->format('d M');

            $grafikMingguanData[] = (clone $queryPenjualan)
                ->whereBetween('tanggal', [$awalMinggu, $akhirMinggu])
                ->sum('total');
        }

        // Grafik penjualan bulanan 6 bulan terakhir
        $grafikBulananLabels = [];
        $grafikBulananData = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            $grafikBulananLabels[] = $bulan->format('M Y');

            $grafikBulananData[] = (clone $queryPenjualan)
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->sum('total');
        }

        return view('dashboard.index', compact(
            'totalBarang',
            'totalKategori',
            'totalRak',
            'stokMenipis',
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksiTerbaru',
            'grafikHarianLabels',
            'grafikHarianData',
            'grafikMingguanLabels',
            'grafikMingguanData',
            'grafikBulananLabels',
            'grafikBulananData'
        ));
    }
}
