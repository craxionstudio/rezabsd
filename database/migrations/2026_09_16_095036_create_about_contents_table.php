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
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_headline')->nullable();
            $table->text('hero_subtext')->nullable();
            $table->text('bio_paragraph_1')->nullable();
            $table->text('bio_paragraph_2')->nullable();
            $table->string('credential_afiliasi')->nullable();
            $table->string('credential_area')->nullable();
            $table->string('credential_pengalaman')->nullable();
            $table->string('credential_kontak')->nullable();
            $table->text('linktown_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};
