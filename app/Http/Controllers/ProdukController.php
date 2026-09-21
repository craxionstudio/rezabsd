<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Setting;
use App\Models\TipeProduk;
use App\Support\TipeProdukSpesifikasi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProdukController extends Controller
{
    /**
     * Single route handles both /produk/{tipeSlug} (path-segment type
     * filter, one crawlable URL per type — see routes/web.php) and
     * /produk/{slug} (detail). A TipeProduk slug match wins; otherwise the
     * segment is looked up as a Produk slug.
     */
    public function showOrFilter(Request $request, string $tipeOrSlug): Response
    {
        $tipe = TipeProduk::where('slug', $tipeOrSlug)->first();

        if ($tipe) {
            return $this->index($request, $tipe);
        }

        $produk = Produk::where('slug', $tipeOrSlug)->firstOrFail();

        return $this->show($produk);
    }

    public function index(Request $request, ?TipeProduk $tipeFilter = null): Response
    {
        $status = $request->string('status')->toString();
        $listingType = $request->string('listing_type')->toString();

        $produks = Produk::query()
            ->published()
            ->with(['tipeProduk', 'tipeUnits'])
            ->when($tipeFilter, fn ($query) => $query->where('tipe_produk_id', $tipeFilter->id))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($listingType, fn ($query) => $query->where('listing_type', $listingType))
            ->latest()
            ->get()
            ->map(function (Produk $produk) {
                $spesifikasi = $produk->representativeTipeUnit();

                return [
                    'nama' => $produk->nama,
                    'slug' => $produk->slug,
                    'tipe' => $produk->tipeProduk->nama,
                    'tipeSlug' => $produk->tipeProduk->slug,
                    'status' => $produk->status,
                    'listing_type' => $produk->listing_type,
                    'hargaLabel' => $produk->hargaLabel(),
                    'lokasi' => $produk->lokasi,
                    'luas_tanah' => $spesifikasi?->luas_tanah,
                    'luas_bangunan' => $spesifikasi?->luas_bangunan,
                    'kamar_tidur' => $spesifikasi?->kamar_tidur,
                    'kamar_mandi' => $spesifikasi?->kamar_mandi,
                    'cover' => $produk->coverThumbUrl(),
                ];
            });

        return Inertia::render('Produk/Index', [
            'produks' => $produks,
            'tipeOptions' => TipeProduk::query()->orderBy('urutan')->get(['nama', 'slug']),
            'activeTipe' => $tipeFilter?->slug,
            'filters' => $request->only(['status', 'listing_type']),
            'seo' => [
                'title' => $tipeFilter ? "Produk {$tipeFilter->nama}" : 'Produk',
                'description' => $tipeFilter
                    ? "Daftar listing {$tipeFilter->nama} yang tersedia di kawasan ini."
                    : 'Daftar listing rumah, ruko, dan kavling yang tersedia.',
                'canonical' => url($tipeFilter ? "/produk/{$tipeFilter->slug}" : '/produk'),
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

    private function show(Produk $produk): Response
    {
        abort_unless($produk->status_tayang === 'published', 404);

        $produk->load(['tipeProduk', 'tipeUnits']);
        $spesifikasi = $produk->representativeTipeUnit();

        $related = Produk::query()
            ->published()
            ->with(['tipeProduk', 'tipeUnits'])
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
                'hargaLabel' => $item->hargaLabel(),
                'lokasi' => $item->lokasi,
                'cover' => $item->coverThumbUrl(),
            ]);

        return Inertia::render('Produk/Show', [
            'produk' => [
                'nama' => $produk->nama,
                'nama_kawasan_induk' => $produk->nama_kawasan_induk,
                'slug' => $produk->slug,
                'tipe' => $produk->tipeProduk->nama,
                'status' => $produk->status,
                'listing_type' => $produk->listing_type,
                'hargaLabel' => $produk->hargaLabel(),
                'lokasi' => $produk->lokasi,
                'promo' => $produk->promo ?? [],
                'specRows' => TipeProdukSpesifikasi::rows($produk->tipeProduk->slug, $spesifikasi, $produk->status),
                'deskripsi' => $produk->deskripsi,
                'gallery' => $produk->galleryUrls(),
                'tipeUnitNames' => $produk->tipeUnits->pluck('nama_tipe')->all(),
            ],
            'related' => $related,
            'seo' => [
                'title' => $produk->meta_title ?: $produk->nama,
                'description' => $produk->meta_description ?: str($produk->deskripsi ?? '')->stripTags()->limit(160)->toString(),
                'canonical' => url("/produk/{$produk->slug}"),
            ],
            'jsonLd' => array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $produk->nama,
                'image' => $produk->galleryUrls(),
                'description' => str($produk->deskripsi ?? '')->stripTags()->toString(),
                'additionalProperty' => $produk->nama_kawasan_induk ? [
                    '@type' => 'PropertyValue',
                    'name' => 'Kawasan',
                    'value' => $produk->nama_kawasan_induk,
                ] : null,
                'offers' => [
                    '@type' => 'Offer',
                    'priceCurrency' => 'IDR',
                    'price' => (string) ($produk->hargaMulaiValue() ?? 0),
                    'availability' => 'https://schema.org/InStock',
                    'seller' => [
                        '@type' => 'RealEstateAgent',
                        'name' => Setting::current()->nama_agensi,
                    ],
                ],
            ]),
        ]);
    }
}
