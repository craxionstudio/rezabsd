<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * These specs moved to tipe_units (one row per Produk minimum) when
     * Produk gained its hasMany TipeUnit relationship.
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['luas_tanah', 'luas_bangunan', 'kamar_tidur', 'kamar_mandi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->unsignedInteger('luas_tanah')->nullable();
            $table->unsignedInteger('luas_bangunan')->nullable();
            $table->unsignedTinyInteger('kamar_tidur')->nullable();
            $table->unsignedTinyInteger('kamar_mandi')->nullable();
        });
    }
};
