<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TipeProduk extends Model
{
    /** @use HasFactory<\Database\Factories\TipeProdukFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'urutan',
    ];

    protected static function booted(): void
    {
        static::saving(function (TipeProduk $tipe) {
            if (blank($tipe->slug)) {
                $tipe->slug = Str::slug($tipe->nama);
            }
        });
    }

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }
}
