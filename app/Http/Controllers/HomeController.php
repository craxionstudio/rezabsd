<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\HomeContent;
use App\Models\Produk;
use App\Models\Setting;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::current();
        $homeContent = HomeContent::current();

        $highlights = Produk::query()
            ->published()
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (Produk $produk) => [
                'nama' => $produk->nama,
                'slug' => $produk->slug,
                'tipe' => $produk->tipe,
                'status' => $produk->status,
                'harga' => $produk->harga,
                'lokasi' => $produk->lokasi,
                'luas_tanah' => $produk->luas_tanah,
                'kamar_tidur' => $produk->kamar_tidur,
                'kamar_mandi' => $produk->kamar_mandi,
                'cover' => $produk->coverImageUrl(),
            ]);

        $artikelHighlights = Artikel::query()
            ->published()
            ->latest('tanggal_publish')
            ->take(3)
            ->get()
            ->map(fn (Artikel $artikel) => [
                'judul' => $artikel->judul,
                'slug' => $artikel->slug,
                'excerpt' => str($artikel->konten)->stripTags()->limit(110)->toString(),
                'featured_image' => $artikel->featuredImageUrl(),
            ]);

        return Inertia::render('Home', [
            'content' => [
                ...$homeContent->only([
                    'hero_eyebrow',
                    'hero_headline',
                    'hero_subtext',
                    'hero_cta_label',
                    'stat_1_value',
                    'stat_1_label',
                    'stat_2_value',
                    'stat_2_label',
                    'stat_3_value',
                    'stat_3_label',
                    'process_step_1_title',
                    'process_step_1_desc',
                    'process_step_2_title',
                    'process_step_2_desc',
                    'process_step_3_title',
                    'process_step_3_desc',
                    'testimonial_quote',
                    'testimonial_name',
                    'cta_banner_title',
                    'cta_banner_subtitle',
                    'cta_banner_button_label',
                ]),
                'hero_image' => $homeContent->heroImageUrl(),
            ],
            'highlights' => $highlights,
            'artikelHighlights' => $artikelHighlights,
            'seo' => [
                'title' => 'Home',
                'description' => "Cari rumah, ruko, dan kavling bersama {$settings->nama_sales}, {$settings->jabatan} dari {$settings->nama_agensi}.",
            ],
            'jsonLd' => [
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'Person',
                    'name' => $settings->nama_sales,
                    'jobTitle' => $settings->jabatan,
                    'worksFor' => [
                        '@type' => 'RealEstateAgent',
                        'name' => $settings->nama_agensi,
                    ],
                ],
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'RealEstateAgent',
                    'name' => $settings->nama_agensi,
                    'address' => $settings->alamat_agensi,
                ],
            ],
        ]);
    }
}
