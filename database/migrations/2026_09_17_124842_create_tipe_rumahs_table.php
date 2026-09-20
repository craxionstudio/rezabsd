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
        Schema::create('tipe_rumahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->cascadeOnDelete();
            $table->string('nama_tipe');
            $table->unsignedInteger('luas_tanah')->nullable();
            $table->unsignedInteger('luas_bangunan')->nullable();
            $table->unsignedTinyInteger('kamar_tidur')->nullable();
            $table->unsignedTinyInteger('kamar_mandi')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_rumahs');
    }
};
