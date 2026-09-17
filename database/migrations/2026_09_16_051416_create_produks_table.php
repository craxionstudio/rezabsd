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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->foreignId('tipe_produk_id')->constrained('tipe_produks')->restrictOnDelete();
            $table->enum('status', ['primary', 'secondary']);
            $table->enum('listing_type', ['jual', 'sewa'])->default('jual');
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('luas_tanah')->nullable();
            $table->unsignedInteger('luas_bangunan')->nullable();
            $table->unsignedTinyInteger('kamar_tidur')->nullable();
            $table->unsignedTinyInteger('kamar_mandi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->enum('status_tayang', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
