<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('tipe_rumahs', 'tipe_units');

        Schema::table('tipe_units', function (Blueprint $table) {
            $table->unsignedTinyInteger('carport')->nullable()->after('kamar_mandi');
            $table->unsignedTinyInteger('jumlah_lantai')->nullable()->after('carport');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipe_units', function (Blueprint $table) {
            $table->dropColumn(['carport', 'jumlah_lantai']);
        });

        Schema::rename('tipe_units', 'tipe_rumahs');
    }
};
