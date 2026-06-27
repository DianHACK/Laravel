
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->integer('harga_modal')->default(0)->after('harga');
            $table->integer('subtotal_modal')->default(0)->after('subtotal');
            $table->integer('laba')->default(0)->after('subtotal_modal');
        });
    }

    public function down(): void
    {
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->dropColumn(['harga_modal', 'subtotal_modal', 'laba']);
        });
    }
};
