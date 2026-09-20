<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * A previous failed deploy attempt already ran a version of this
     * migration under a different filename, which created `tipe_units`
     * fresh (with carport/jumlah_lantai already included) rather than
     * renaming `tipe_rumahs` into it. That table may since have picked up
     * real rows through the admin panel, so we can't just drop it and
     * rename — merge tipe_rumahs' rows into it instead, then drop
     * tipe_rumahs. On an install where that never happened, tipe_units
     * won't exist yet and we fall back to the normal rename.
     */
    public function up(): void
    {
        if (Schema::hasTable('tipe_units')) {
            DB::table('tipe_rumahs')->orderBy('id')->each(function ($row) {
                DB::table('tipe_units')->insert([
                    'produk_id' => $row->produk_id,
                    'nama_tipe' => $row->nama_tipe,
                    'luas_tanah' => $row->luas_tanah,
                    'luas_bangunan' => $row->luas_bangunan,
                    'kamar_tidur' => $row->kamar_tidur,
                    'kamar_mandi' => $row->kamar_mandi,
                    'urutan' => $row->urutan,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            });

            Schema::dropIfExists('tipe_rumahs');

            return;
        }

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
