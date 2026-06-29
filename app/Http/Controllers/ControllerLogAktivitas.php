<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerLogAktivitas 
{
    public function index(Request $request)
    {
        $query = LogAktivitas::query()
            ->orderBy('created_at', 'desc');

        if ($request->id_user) {
            $query->where('id_user', $request->id_user);
        }

        if ($request->modul) {
            $query->where('modul', $request->modul);
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereDate('created_at', '>=', $request->tanggal_awal)
                  ->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('aktivitas', 'like', '%' . $request->keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->keyword . '%')
                  ->orWhere('nama_user', 'like', '%' . $request->keyword . '%');
            });
        }

        $logs = $query->get();

        $users = User::orderBy('name', 'asc')->get();

        $moduls = LogAktivitas::select('modul')
            ->whereNotNull('modul')
            ->distinct()
            ->orderBy('modul', 'asc')
            ->pluck('modul');

        return view('log-aktivitas.index', compact(
            'logs',
            'users',
            'moduls'
        ));
    }
}
