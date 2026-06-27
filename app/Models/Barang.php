<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Rak;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'id_kategori',
        'id_rak',
        'harga',
        'harga_modal',
        'diskon',
        'stok',
        'gambar',
        'expired_date',
        'deskripsi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak');
    }
}
