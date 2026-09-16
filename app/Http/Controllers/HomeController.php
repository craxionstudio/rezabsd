<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Setting;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::current();

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
                'kamar_tidur' => $produk->kamar_tidur,
                'kamar_mandi' => $produk->kamar_mandi,
                'cover' => $produk->coverImageUrl(),
            ]);

        return Inertia::render('Home', [
            'highlights' => $highlights,
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
