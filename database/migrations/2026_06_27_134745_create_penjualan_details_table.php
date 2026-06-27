<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_barang');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id')->on('penjualan')->cascadeOnDelete();
            $table->foreign('id_barang')->references('id')->on('barang')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
