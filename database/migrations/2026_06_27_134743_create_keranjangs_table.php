<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_barang')->references('id')->on('barang')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
