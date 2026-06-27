<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerRiwayatTransaksi
{
    public function index(Request $request)
    {
        $query = Penjualan::with('user')->orderBy('tanggal', 'desc');

        if (Auth::user()->role == 'kasir') {
            $query->where('id_user', Auth::id());
        }

        if (Auth::user()->role == 'admin' && $request->id_user) {
            $query->where('id_user', $request->id_user);
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal)
                  ->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $riwayats = $query->get();

        $totalTransaksi = $riwayats->count();
        $totalPendapatan = $riwayats->sum('total');

        $kasirs = User::whereIn('role', ['admin', 'kasir'])
            ->orderBy('name', 'asc')
            ->get();

        return view('riwayat.index', compact(
            'riwayats',
            'totalTransaksi',
            'totalPendapatan',
            'kasirs'
        ));
    }

    public function detail($id)
    {
        $penjualan = Penjualan::with(['detail.barang', 'user'])->findOrFail($id);

        if (Auth::user()->role == 'kasir' && $penjualan->id_user != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        return view('riwayat.detail', compact('penjualan'));
    }
}
