<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Artikel extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ArtikelFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori_id',
        'meta_title',
        'meta_description',
        'tanggal_publish',
        'status_tayang',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publish' => 'datetime',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile()->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(600)->nonQueued();
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status_tayang', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function featuredImageUrl(): ?string
    {
        return $this->getFirstMediaUrl('featured_image') ?: null;
    }

    /**
     * Smaller derivative for the Artikel index/grid cards.
     */
    public function featuredImageThumbUrl(): ?string
    {
        return $this->getFirstMediaUrl('featured_image', 'thumb') ?: $this->featuredImageUrl();
    }
}
