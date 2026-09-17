<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalContent extends Model
{
    protected $fillable = [
        'privacy_policy',
        'terms_conditions',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
