<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';

    protected $fillable = [
        'id_penjualan',
        'id_barang',
        'jumlah',
        'harga',
        'harga_modal',
        'subtotal',
        'subtotal_modal',
        'laba',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
