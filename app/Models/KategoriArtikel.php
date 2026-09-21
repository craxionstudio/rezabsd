<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class KategoriArtikel extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriArtikelFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi_singkat',
        'urutan',
    ];

    protected static function booted(): void
    {
        static::saving(function (KategoriArtikel $kategori) {
            if (blank($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function artikels(): HasMany
    {
        return $this->hasMany(Artikel::class, 'kategori_id');
    }
}
