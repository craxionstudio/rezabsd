# Spec Teknis — Website Personal Branding Reza Alhadithia (Linktown)

## 1. Latar Belakang & Tujuan

Website ini adalah bagian dari solusi atas masalah suspend Google Ads "Unacceptable Business Practices" yang berulang pada model "1 website = 1 kawasan/developer". Model baru: **1 website = 1 sales individual** (pilot: Reza Alhadithia), dengan identitas dan afiliasi ke Linktown yang jelas sejak awal.

**Requirement compliance yang non-negotiable:**
- Identitas operator situs (Reza + Linktown) harus jelas di setiap halaman utama, bukan tersembunyi.
- Disclaimer eksplisit bahwa ini bukan situs resmi developer/kawasan.
- Tidak menggunakan logo/warna resmi milik developer/kawasan tanpa izin tertulis.
- Domain menggunakan nama personal Reza / Linktown, **bukan** nama kawasan/developer.

Status: pilot 1 situs (Reza), belum didesain multi-tenant. Konten (Produk & Artikel) di-input oleh developer (Farrel/Faiz), jadi kemudahan UI CMS untuk non-teknis bukan prioritas utama.

## 2. Stack Teknis

| Layer | Pilihan | Alasan |
|---|---|---|
| Backend | Laravel (stable terbaru) | Stack yang sudah familiar buat Faiz |
| Admin/CMS | Filament | Admin panel CRUD siap pakai untuk Produk & Artikel |
| Frontend | Inertia.js + React + Tailwind CSS | React tanpa perlu bikin API terpisah; tetap 1 codebase. Styling pakai Tailwind, **bukan Next.js** — Next.js nggak dipakai di stack ini |
| SSR | Inertia SSR (Node.js render process) | Wajib — supaya JSON-LD schema & konten ter-render di HTML awal, kebaca crawler Google |
| Database | MySQL | Sesuai stack existing |
| Media | Spatie Laravel Media Library | Upload & auto-resize galeri foto listing |
| Sitemap | Spatie Laravel Sitemap | Auto-generate sitemap.xml dari Produk + Artikel |

**Catatan setup SSR:** Inertia SSR butuh Node.js process berjalan terus (`php artisan inertia:start-ssr` di production, biasanya di-supervise pakai Supervisor/PM2). Kalau di-deploy manual di VPS, ini satu proses tambahan di luar PHP-FPM biasa — jangan lupa masuk ke deployment checklist.

## 3. Struktur Halaman & Requirement Konten

### Home
- Hero: identitas Reza + Linktown, foto, tagline
- Highlight 3–6 listing unggulan
- CTA kontak (WhatsApp)
- Schema: `Person` (Reza) + `Organization`/`RealEstateAgent` (Linktown)

### About Us
- Bio Reza (pengalaman, nomor lisensi/sertifikasi jika ada)
- Penjelasan Linktown sebagai agent properti
- **Disclaimer wajib tampil**, contoh teks:
  > "Website ini adalah kanal pemasaran independen milik Reza Alhadithia, sales dari Linktown, dan bukan situs resmi dari developer/kawasan yang produknya dipasarkan di sini."
- Schema: `Person` lengkap (jobTitle, worksFor, sameAs ke social media)

Contoh JSON-LD untuk halaman About Us:
```json
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Reza Alhadithia",
  "jobTitle": "Sales Marketing Properti",
  "worksFor": {
    "@type": "RealEstateAgent",
    "name": "Linktown"
  },
  "sameAs": [
    "https://instagram.com/username_reza"
  ]
}
```

### Produk (Listing)
- Filter: tipe (Rumah / Ruko / Kavling), status (Primary / Secondary)
- Card listing: foto, harga, lokasi, LT/LB, kamar
- Terkunci ke 1 kawasan — untuk pilot, filter lokasi bisa di-hardcode di config, tidak perlu dynamic multi-kawasan dulu
- Schema: `ItemList` berisi beberapa `Product`

### Detail Produk
- Galeri foto
- Spesifikasi: LT, LB, kamar tidur/mandi, harga, status (primary/secondary)
- CTA WhatsApp dengan prefilled message (nama produk otomatis masuk ke teks chat)
- Related listing (produk lain di kawasan yang sama)
- Schema: `Product` dengan `offers`

Contoh JSON-LD untuk Detail Produk:
```json
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "Rumah Tipe 45/90 - Blok A",
  "image": "https://domain.com/media/rumah-a1.jpg",
  "description": "Rumah 2 lantai, 3 kamar tidur, 2 kamar mandi.",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "IDR",
    "price": "850000000",
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "RealEstateAgent",
      "name": "Linktown"
    }
  }
}
```

### Artikel
- List artikel + kategori (tips beli rumah, info kawasan, dll)
- Detail: rich text editor, featured image, author = Reza
- Schema: `Article` (author, datePublished, image)

## 4. Data Model — Filament Resources

**ProdukResource**
- `nama`, `tipe` (enum: rumah/ruko/kavling), `status` (enum: primary/secondary)
- `harga`, `luas_tanah`, `luas_bangunan`, `kamar_tidur`, `kamar_mandi`
- `deskripsi`, `galeri` (media collection), `slug`
- `meta_title`, `meta_description`, `status_tayang` (draft/published)

**ArtikelResource**
- `judul`, `slug`, `konten` (rich text), `kategori`, `featured_image`
- `meta_title`, `meta_description`, `tanggal_publish`, `status_tayang`

**SettingsResource** (single record/global)
- Kontak Reza (WA, email), alamat Linktown, link social media
- Teks disclaimer About Us — dibuat editable dari sini, **jangan** di-hardcode di Blade/React, supaya bisa direvisi cepat kalau ada perubahan kebijakan tanpa deploy ulang

## 5. SEO Checklist (Non-Negotiable)

- [ ] Setiap halaman punya meta title & description unik, editable dari Filament
- [ ] JSON-LD di-render **server-side** lewat Inertia SSR — bukan di-inject via JS di client, supaya crawler pasti dapat
- [ ] Sitemap.xml auto-update tiap ada Produk/Artikel baru (via Spatie Sitemap + scheduled job atau event listener)
- [ ] robots.txt standar, allow crawl untuk halaman publik
- [ ] URL slug deskriptif (`/produk/rumah-tipe-45-90-blok-a`, bukan `/produk/123`)
- [ ] Gambar pakai `alt` text deskriptif

## 6. Hosting & Infra

- VPS dengan PHP-FPM (Laravel) + proses Node.js terpisah untuk Inertia SSR
- Kalau tim belum familiar setup manual: pertimbangkan Laravel Forge untuk otomasi deployment + queue + SSR process supervision
- SSL wajib (Let's Encrypt)

## 7. Cara Pakai Dokumen Ini

Dokumen ini bisa langsung dijadikan brief untuk Farrel/Faiz, atau di-paste sebagai prompt ke tool AI coding (Claude Code, dll.) untuk scaffolding awal project — cukup tempel section 2–4 sebagai instruksi awal, lalu lanjutkan iteratif per halaman.
