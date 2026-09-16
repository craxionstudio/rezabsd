<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'foto_profil',
        'disclaimer',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function fotoProfilUrl(): ?string
    {
        return $this->foto_profil ? Storage::disk('public')->url($this->foto_profil) : null;
    }
}
