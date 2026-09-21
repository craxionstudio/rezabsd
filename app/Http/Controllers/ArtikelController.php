<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArtikelController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->render($request);
    }

    public function kategori(Request $request, KategoriArtikel $kategori): Response
    {
        return $this->render($request, $kategori);
    }

    private function render(Request $request, ?KategoriArtikel $activeKategori = null): Response
    {
        $artikels = Artikel::query()
            ->published()
            ->with('kategori')
            ->when($activeKategori, fn ($query) => $query->where('kategori_id', $activeKategori->id))
            ->latest('tanggal_publish')
            ->get()
            ->map(fn (Artikel $artikel) => [
                'judul' => $artikel->judul,
                'slug' => $artikel->slug,
                'kategori' => $artikel->kategori?->nama,
                'kategoriSlug' => $artikel->kategori?->slug,
                'excerpt' => str($artikel->konten)->stripTags()->limit(140)->toString(),
                'tanggal_publish' => $artikel->tanggal_publish?->translatedFormat('d F Y'),
                'featured_image' => $artikel->featuredImageUrl(),
                'featured_image_thumb' => $artikel->featuredImageThumbUrl(),
            ]);

        $featured = null;
        $rest = $artikels;

        if (! $activeKategori) {
            $featured = $artikels->first();
            $rest = $artikels->slice(1)->values();
        }

        return Inertia::render('Artikel/Index', [
            'featured' => $featured,
            'artikels' => $rest,
            'kategoriOptions' => KategoriArtikel::query()->orderBy('urutan')->get(['nama', 'slug']),
            'activeKategoriSlug' => $activeKategori?->slug,
            'kategoriInfo' => $activeKategori ? [
                'nama' => $activeKategori->nama,
                'deskripsi_singkat' => $activeKategori->deskripsi_singkat,
            ] : null,
            'seo' => [
                'title' => $activeKategori ? $activeKategori->nama : 'Artikel',
                'description' => $activeKategori
                    ? ($activeKategori->deskripsi_singkat ?: "Artikel seputar {$activeKategori->nama}.")
                    : 'Tips membeli rumah, info kawasan, dan artikel properti lainnya.',
                'canonical' => url($activeKategori ? "/artikel/kategori/{$activeKategori->slug}" : '/artikel'),
            ],
            'jsonLd' => $activeKategori ? [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $activeKategori->nama,
                'description' => $activeKategori->deskripsi_singkat,
            ] : [
                '@context' => 'https://schema.org',
                '@type' => 'Blog',
                'name' => 'Artikel — Reza Alhadithia',
            ],
        ]);
    }

    public function show(Artikel $artikel): Response
    {
        abort_unless($artikel->status_tayang === 'published', 404);

        $artikel->load('kategori');

        return Inertia::render('Artikel/Show', [
            'artikel' => [
                'judul' => $artikel->judul,
                'slug' => $artikel->slug,
                'konten' => $artikel->konten,
                'kategori' => $artikel->kategori?->nama,
                'kategoriSlug' => $artikel->kategori?->slug,
                'tanggal_publish' => $artikel->tanggal_publish?->toDateString(),
                'featured_image' => $artikel->featuredImageUrl(),
            ],
            'seo' => [
                'title' => $artikel->meta_title ?: $artikel->judul,
                'description' => $artikel->meta_description ?: str($artikel->konten)->stripTags()->limit(160)->toString(),
                'canonical' => url("/artikel/{$artikel->slug}"),
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
