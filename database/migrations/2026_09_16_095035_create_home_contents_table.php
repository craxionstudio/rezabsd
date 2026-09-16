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
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_eyebrow')->nullable();
            $table->string('hero_headline')->nullable();
            $table->text('hero_subtext')->nullable();
            $table->string('hero_cta_label')->nullable();
            $table->string('stat_1_value')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_2_value')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_3_value')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('process_step_1_title')->nullable();
            $table->text('process_step_1_desc')->nullable();
            $table->string('process_step_2_title')->nullable();
            $table->text('process_step_2_desc')->nullable();
            $table->string('process_step_3_title')->nullable();
            $table->text('process_step_3_desc')->nullable();
            $table->text('testimonial_quote')->nullable();
            $table->string('testimonial_name')->nullable();
            $table->string('cta_banner_title')->nullable();
            $table->text('cta_banner_subtitle')->nullable();
            $table->string('cta_banner_button_label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
