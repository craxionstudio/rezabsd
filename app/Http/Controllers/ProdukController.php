<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Setting;
use App\Models\TipeProduk;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProdukController extends Controller
{
    public function index(Request $request): Response
    {
        $tipeSlug = $request->string('tipe')->toString();
        $status = $request->string('status')->toString();
        $listingType = $request->string('listing_type')->toString();

        $produks = Produk::query()
            ->published()
            ->with(['tipeProduk', 'tipeRumahs'])
            ->when($tipeSlug, fn ($query) => $query->whereHas('tipeProduk', fn ($q) => $q->where('slug', $tipeSlug)))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($listingType, fn ($query) => $query->where('listing_type', $listingType))
            ->latest()
            ->get()
            ->map(function (Produk $produk) {
                $spesifikasi = $produk->representativeTipeRumah();

                return [
                    'nama' => $produk->nama,
                    'slug' => $produk->slug,
                    'tipe' => $produk->tipeProduk->nama,
                    'tipeSlug' => $produk->tipeProduk->slug,
                    'status' => $produk->status,
                    'listing_type' => $produk->listing_type,
                    'harga' => $produk->harga,
                    'lokasi' => $produk->lokasi,
                    'luas_tanah' => $spesifikasi?->luas_tanah,
                    'luas_bangunan' => $spesifikasi?->luas_bangunan,
                    'kamar_tidur' => $spesifikasi?->kamar_tidur,
                    'kamar_mandi' => $spesifikasi?->kamar_mandi,
                    'cover' => $produk->coverImageUrl(),
                ];
            });

        return Inertia::render('Produk/Index', [
            'produks' => $produks,
            'tipeOptions' => TipeProduk::query()->orderBy('urutan')->get(['nama', 'slug']),
            'filters' => $request->only(['tipe', 'status', 'listing_type']),
            'seo' => [
                'title' => 'Produk',
                'description' => 'Daftar listing rumah, ruko, dan kavling yang tersedia.',
            ],
            'jsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'ItemList',
                'itemListElement' => $produks->values()->map(fn ($produk, $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => [
                        '@type' => 'Product',
                        'name' => $produk['nama'],
                        'url' => route('produk.show', $produk['slug']),
                    ],
                ])->all(),
            ],
        ]);
    }

    public function show(Produk $produk): Response
    {
        abort_unless($produk->status_tayang === 'published', 404);

        $produk->load(['tipeProduk', 'tipeRumahs']);
        $spesifikasi = $produk->representativeTipeRumah();

        $related = Produk::query()
            ->published()
            ->with(['tipeProduk', 'tipeRumahs'])
            ->where('lokasi', $produk->lokasi)
            ->where('id', '!=', $produk->id)
            ->take(3)
            ->get()
            ->map(fn (Produk $item) => [
                'nama' => $item->nama,
                'slug' => $item->slug,
                'tipe' => $item->tipeProduk->nama,
                'status' => $item->status,
                'listing_type' => $item->listing_type,
                'harga' => $item->harga,
                'lokasi' => $item->lokasi,
                'cover' => $item->coverImageUrl(),
            ]);

        return Inertia::render('Produk/Show', [
            'produk' => [
                'nama' => $produk->nama,
                'slug' => $produk->slug,
                'tipe' => $produk->tipeProduk->nama,
                'status' => $produk->status,
                'listing_type' => $produk->listing_type,
                'harga' => $produk->harga,
                'lokasi' => $produk->lokasi,
                'luas_tanah' => $spesifikasi?->luas_tanah,
                'luas_bangunan' => $spesifikasi?->luas_bangunan,
                'kamar_tidur' => $spesifikasi?->kamar_tidur,
                'kamar_mandi' => $spesifikasi?->kamar_mandi,
                'deskripsi' => $produk->deskripsi,
                'gallery' => $produk->galleryUrls(),
                'tipeRumahNames' => $produk->tipeRumahs->pluck('nama_tipe')->all(),
            ],
            'related' => $related,
            'seo' => [
                'title' => $produk->meta_title ?: $produk->nama,
                'description' => $produk->meta_description ?: str($produk->deskripsi ?? '')->stripTags()->limit(160)->toString(),
            ],
            'jsonLd' => [
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $produk->nama,
                'image' => $produk->galleryUrls(),
                'description' => str($produk->deskripsi ?? '')->stripTags()->toString(),
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'IDR',
                    'price' => (string) $produk->harga,
                    'availability' => 'https://schema.org/InStock',
                    'seller' => [
                        '@type' => 'RealEstateAgent',
                        'name' => Setting::current()->nama_agensi,
                    ],
                ],
            ],
        ]);
    }
}
