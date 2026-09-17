<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TipeRumah extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TipeRumahFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'produk_id',
        'nama_tipe',
        'luas_tanah',
        'luas_bangunan',
        'kamar_tidur',
        'kamar_mandi',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'luas_tanah' => 'integer',
            'luas_bangunan' => 'integer',
            'kamar_tidur' => 'integer',
            'kamar_mandi' => 'integer',
            'urutan' => 'integer',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galeri')->useDisk('public');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function galleryUrls(): array
    {
        return $this->getMedia('galeri')->map(fn (Media $media) => $media->getUrl())->all();
    }
}
