<?php

namespace App\Models;

use App\Support\Rupiah;
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
        'nama_kawasan_induk',
        'slug',
        'tipe_produk_id',
        'status',
        'listing_type',
        'mode_harga',
        'cicilan_mulai',
        'harga_mulai',
        'promo',
        'deskripsi',
        'lokasi',
        'meta_title',
        'meta_description',
        'status_tayang',
    ];

    protected function casts(): array
    {
        return [
            'cicilan_mulai' => 'integer',
            'harga_mulai' => 'integer',
            'promo' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galeri')->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(600)->nonQueued();
    }

    public function tipeProduk(): BelongsTo
    {
        return $this->belongsTo(TipeProduk::class);
    }

    public function tipeUnits(): HasMany
    {
        return $this->hasMany(TipeUnit::class)->orderBy('urutan');
    }

    /**
     * The TipeUnit whose specs represent this Produk on listing cards and
     * the detail page — the one with the lowest urutan.
     */
    public function representativeTipeUnit(): ?TipeUnit
    {
        return $this->tipeUnits->first();
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

    /**
     * Smaller derivative for listing cards (Produk index, Home highlights,
     * related listings) — falls back to the full image while the thumb
     * conversion hasn't finished (e.g. right after upload).
     */
    public function coverThumbUrl(): ?string
    {
        return $this->getFirstMediaUrl('galeri', 'thumb') ?: $this->coverImageUrl();
    }

    public function galleryUrls(): array
    {
        return $this->getMedia('galeri')->map(fn (Media $media) => $media->getUrl())->all();
    }

    /**
     * The raw rupiah value driving the "Mulai dari" price display, sourced
     * from cicilan_mulai or harga_mulai depending on mode_harga.
     */
    public function hargaMulaiValue(): ?int
    {
        return $this->mode_harga === 'cicilan' ? $this->cicilan_mulai : $this->harga_mulai;
    }

    public function hargaLabel(): string
    {
        $value = $this->hargaMulaiValue();

        if ($value === null) {
            return '-';
        }

        $suffix = $this->mode_harga === 'cicilan' ? '/bulan' : '';

        return 'Mulai dari '.Rupiah::singkat($value).$suffix;
    }
}
