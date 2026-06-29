<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko')->default('Sistem Swalayan');
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('qris')->nullable();
            $table->string('bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_toko');
    }
};
