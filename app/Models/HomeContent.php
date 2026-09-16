<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    protected $fillable = [
        'hero_eyebrow',
        'hero_headline',
        'hero_subtext',
        'hero_cta_label',
        'stat_1_value',
        'stat_1_label',
        'stat_2_value',
        'stat_2_label',
        'stat_3_value',
        'stat_3_label',
        'process_step_1_title',
        'process_step_1_desc',
        'process_step_2_title',
        'process_step_2_desc',
        'process_step_3_title',
        'process_step_3_desc',
        'testimonial_quote',
        'testimonial_name',
        'cta_banner_title',
        'cta_banner_subtitle',
        'cta_banner_button_label',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
