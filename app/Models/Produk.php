<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'tipe_produk_id',
        'status',
        'listing_type',
        'harga',
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
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galeri')->useDisk('public');
    }

    public function tipeProduk(): BelongsTo
    {
        return $this->belongsTo(TipeProduk::class);
    }

    public function tipeRumahs(): HasMany
    {
        return $this->hasMany(TipeRumah::class)->orderBy('urutan');
    }

    /**
     * The TipeRumah whose specs (LT/LB/kamar) represent this Produk on
     * listing cards and the detail page — the one with the lowest urutan.
     */
    public function representativeTipeRumah(): ?TipeRumah
    {
        return $this->tipeRumahs->first();
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
