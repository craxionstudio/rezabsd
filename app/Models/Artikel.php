<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Artikel extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ArtikelFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'kategori',
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
}
