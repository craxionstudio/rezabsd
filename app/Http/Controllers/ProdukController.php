<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProdukController extends Controller
{
    public function index(Request $request): Response
    {
        $produks = Produk::query()
            ->published()
            ->when($request->string('tipe')->toString(), fn ($query, $tipe) => $query->where('tipe', $tipe))
            ->when($request->string('status')->toString(), fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->get()
            ->map(fn (Produk $produk) => [
                'nama' => $produk->nama,
                'slug' => $produk->slug,
                'tipe' => $produk->tipe,
                'status' => $produk->status,
                'harga' => $produk->harga,
                'lokasi' => $produk->lokasi,
                'luas_tanah' => $produk->luas_tanah,
                'luas_bangunan' => $produk->luas_bangunan,
                'kamar_tidur' => $produk->kamar_tidur,
                'kamar_mandi' => $produk->kamar_mandi,
                'cover' => $produk->coverImageUrl(),
            ]);

        return Inertia::render('Produk/Index', [
            'produks' => $produks,
            'filters' => $request->only(['tipe', 'status']),
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

        $related = Produk::query()
            ->published()
            ->where('lokasi', $produk->lokasi)
            ->where('id', '!=', $produk->id)
            ->take(3)
            ->get()
            ->map(fn (Produk $item) => [
                'nama' => $item->nama,
                'slug' => $item->slug,
                'tipe' => $item->tipe,
                'status' => $item->status,
                'harga' => $item->harga,
                'lokasi' => $item->lokasi,
                'cover' => $item->coverImageUrl(),
            ]);

        return Inertia::render('Produk/Show', [
            'produk' => [
                'nama' => $produk->nama,
                'slug' => $produk->slug,
                'tipe' => $produk->tipe,
                'status' => $produk->status,
                'harga' => $produk->harga,
                'lokasi' => $produk->lokasi,
                'luas_tanah' => $produk->luas_tanah,
                'luas_bangunan' => $produk->luas_bangunan,
                'kamar_tidur' => $produk->kamar_tidur,
                'kamar_mandi' => $produk->kamar_mandi,
                'deskripsi' => $produk->deskripsi,
                'gallery' => $produk->galleryUrls(),
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
