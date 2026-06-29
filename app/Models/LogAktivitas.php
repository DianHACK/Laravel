<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'id_user',
        'nama_user',
        'role',
        'aktivitas',
        'modul',
        'deskripsi',
        'ip_address',
        'user_agent',
    ];

    public static function catat($aktivitas, $modul = null, $deskripsi = null)
    {
        $user = Auth::user();

        self::create([
            'id_user' => $user->id ?? null,
            'nama_user' => $user->name ?? 'Guest',
            'role' => $user->role ?? '-',
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
