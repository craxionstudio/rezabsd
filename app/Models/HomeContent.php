<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeContent extends Model
{
    protected $fillable = [
        'hero_eyebrow',
        'hero_headline',
        'hero_subtext',
        'hero_cta_label',
        'hero_image',
        'process_step_1_title',
        'process_step_1_desc',
        'process_step_2_title',
        'process_step_2_desc',
        'process_step_3_title',
        'process_step_3_desc',
        'cta_banner_title',
        'cta_banner_subtitle',
        'cta_banner_button_label',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function heroImageUrl(): ?string
    {
        return $this->hero_image ? Storage::disk('public')->url($this->hero_image) : null;
    }
}
