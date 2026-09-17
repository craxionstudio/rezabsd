<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PromoBanner extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'judul',
        'link_url',
        'urutan',
        'status_tayang',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gambar')->singleFile()->useDisk('public');
    }

    public function scopePublished($query)
    {
        return $query->where('status_tayang', 'published');
    }

    public function gambarUrl(): ?string
    {
        return $this->getFirstMediaUrl('gambar') ?: null;
    }
}
