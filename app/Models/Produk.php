<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Produk extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'nama',
        'slug',
        'tipe',
        'status',
        'harga',
        'luas_tanah',
        'luas_bangunan',
        'kamar_tidur',
        'kamar_mandi',
        'deskripsi',
        'lokasi',
        'meta_title',
        'meta_description',
        'status_tayang',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'luas_tanah' => 'integer',
            'luas_bangunan' => 'integer',
            'kamar_tidur' => 'integer',
            'kamar_mandi' => 'integer',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galeri');
    }

    public function scopePublished($query)
    {
        return $query->where('status_tayang', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function coverImageUrl(): ?string
    {
        return $this->getFirstMediaUrl('galeri') ?: null;
    }

    public function galleryUrls(): array
    {
        return $this->getMedia('galeri')->map(fn (Media $media) => $media->getUrl())->all();
    }
}
