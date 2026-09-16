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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sales')->default('Reza Alhadithia');
            $table->string('jabatan')->default('Sales Marketing Properti');
            $table->string('nama_agensi')->default('Linktown');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat_agensi')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->text('bio')->nullable();
            $table->text('disclaimer')->default(
                'Website ini adalah kanal pemasaran independen milik Reza Alhadithia, sales dari Linktown, dan bukan situs resmi dari developer/kawasan yang produknya dipasarkan di sini.'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
