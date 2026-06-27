<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'kode_transaksi',
        'id_user',
        'tanggal',
        'total',
        'bayar',
        'metode_pembayaran',
        'kembalian',
        'status',
    ];

    public function detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
