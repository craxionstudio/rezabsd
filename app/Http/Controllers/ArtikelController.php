<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Setting;
use Inertia\Inertia;
use Inertia\Response;

class ArtikelController extends Controller
{
    public function index(): Response
    {
        $artikels = Artikel::query()
            ->published()
            ->latest('tanggal_publish')
            ->get()
            ->map(fn (Artikel $artikel) => [
                'judul' => $artikel->judul,
                'slug' => $artikel->slug,
                'kategori' => $artikel->kategori,
                'tanggal_publish' => $artikel->tanggal_publish?->toDateString(),
                'featured_image' => $artikel->featuredImageUrl(),
            ]);

        return Inertia::render('Artikel/Index', [
            'artikels' => $artikels,
            'seo' => [
                'title' => 'Artikel',
                'description' => 'Tips membeli rumah, info kawasan, dan artikel properti lainnya.',
            ],
        ]);
    }

    public function show(Artikel $artikel): Response
    {
        abort_unless($artikel->status_tayang === 'published', 404);

        return Inertia::render('Artikel/Show', [
            'artikel' => [
                'judul' => $artikel->judul,
                'slug' => $artikel->slug,
                'konten' => $artikel->konten,
                'kategori' => $artikel->kategori,
                'tanggal_publish' => $artikel->tanggal_publish?->toDateString(),
                'featured_image' => $artikel->featuredImageUrl(),
            ],
            'seo' => [
                'title' => $artikel->meta_title ?: $artikel->judul,
                'description' => $artikel->meta_description ?: str($artikel->konten)->stripTags()->limit(160)->toString(),
            ],
            'jsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $artikel->judul,
                'image' => $artikel->featuredImageUrl(),
                'datePublished' => $artikel->tanggal_publish?->toIso8601String(),
                'author' => [
                    '@type' => 'Person',
                    'name' => Setting::current()->nama_sales,
                ],
            ],
        ]);
    }
}
