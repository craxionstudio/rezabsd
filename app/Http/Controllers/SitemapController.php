<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Produk;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setPriority(1.0))
            ->add(Url::create(route('about'))->setPriority(0.8))
            ->add(Url::create(route('produk.index'))->setPriority(0.9))
            ->add(Url::create(route('artikel.index'))->setPriority(0.7));

        Produk::query()->published()->each(
            fn (Produk $produk) => $sitemap->add(
                Url::create(route('produk.show', $produk->slug))
                    ->setLastModificationDate($produk->updated_at)
                    ->setPriority(0.8)
            )
        );

        Artikel::query()->published()->each(
            fn (Artikel $artikel) => $sitemap->add(
                Url::create(route('artikel.show', $artikel->slug))
                    ->setLastModificationDate($artikel->updated_at)
                    ->setPriority(0.6)
            )
        );

        return response($sitemap->render(), 200, ['Content-Type' => 'application/xml']);
    }
}
