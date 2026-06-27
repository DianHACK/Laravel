<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $table = 'stok_barang';

    protected $fillable = [
        'id_barang',
        'id_user',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'tanggal',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
