<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
// {tipeOrSlug} handles both /produk/rumah (type filter, path segment per SEO
// requirement) and /produk/{slug} (detail) — a TipeProduk slug match wins,
// otherwise it's treated as a Produk slug. See ProdukController::showOrFilter().
Route::get('/produk/{tipeOrSlug}', [ProdukController::class, 'showOrFilter'])->name('produk.show');

Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/kategori/{kategori:slug}', [ArtikelController::class, 'kategori'])->name('artikel.kategori');
Route::get('/artikel/{artikel:slug}', [ArtikelController::class, 'show'])->name('artikel.show');

Route::get('/kebijakan-privasi', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/syarat-ketentuan', [LegalController::class, 'terms'])->name('legal.terms');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
