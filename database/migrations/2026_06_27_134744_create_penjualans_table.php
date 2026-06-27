<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->unsignedBigInteger('id_user');
            $table->dateTime('tanggal');
            $table->integer('total');
            $table->integer('bayar');
            $table->integer('kembalian');
            $table->string('status')->default('selesai');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
