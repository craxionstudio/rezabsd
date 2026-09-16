<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    protected $fillable = [
        'hero_headline',
        'hero_subtext',
        'bio_paragraph_1',
        'bio_paragraph_2',
        'credential_afiliasi',
        'credential_area',
        'credential_pengalaman',
        'credential_kontak',
        'linktown_description',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
