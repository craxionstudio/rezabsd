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
     * Replaces the flat `harga` column with mode_harga (cicilan/harga) +
     * cicilan_mulai + harga_mulai + promo, so existing rows' prices are
     * backfilled into harga_mulai (mode_harga = 'harga') before the old
     * column is dropped — no data is lost.
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->enum('mode_harga', ['cicilan', 'harga'])->default('cicilan')->after('listing_type');
            $table->unsignedBigInteger('cicilan_mulai')->nullable()->after('mode_harga');
            $table->unsignedBigInteger('harga_mulai')->nullable()->after('cicilan_mulai');
            $table->json('promo')->nullable()->after('harga_mulai');
        });

        DB::table('produks')->update([
            'mode_harga' => 'harga',
            'harga_mulai' => DB::raw('harga'),
        ]);

        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->unsignedBigInteger('harga')->default(0);
        });

        DB::table('produks')->update([
            'harga' => DB::raw('COALESCE(harga_mulai, cicilan_mulai, 0)'),
        ]);

        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['mode_harga', 'cicilan_mulai', 'harga_mulai', 'promo']);
        });
    }
};
