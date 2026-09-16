<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'nama_sales',
        'jabatan',
        'nama_agensi',
        'whatsapp',
        'email',
        'alamat_agensi',
        'instagram',
        'facebook',
        'tiktok',
        'bio',
        'disclaimer',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
