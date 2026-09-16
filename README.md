# Website Reza Alhadithia — Linktown

Website personal branding untuk Reza Alhadithia (sales dari Linktown), dibangun sesuai spec:
Laravel 12 + Filament 5 (admin/CMS) + Inertia.js + React + Tailwind CSS, dengan Inertia SSR
supaya konten & JSON-LD ter-render di HTML awal (kebaca crawler Google).

## Requirement

- PHP 8.2+ dan Composer
- Node.js 18+ dan npm

## Instalasi Pertama Kali

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
```

Seeder akan membuat:
- User admin: **admin@example.com** / **password**
- 1 record Settings (identitas Reza + Linktown, disclaimer)
- 9 contoh Produk & 6 contoh Artikel (dummy, tanpa foto)

> Default database pakai **SQLite** (`database/database.sqlite`) supaya gampang dijalankan
> lokal. Untuk production, ganti `DB_CONNECTION` di `.env` ke `mysql` sesuai spec.

## Menjalankan di Lokal (Development)

Butuh **2 proses jalan bersamaan** di 2 terminal:

**Terminal 1 — Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Vite (build & hot-reload React/Tailwind):**
```bash
npm run dev
```

Buka:
- Website publik: http://127.0.0.1:8000
- Admin panel (Filament): http://127.0.0.1:8000/admin — login pakai `admin@example.com` / `password`

Di mode `npm run dev`, JSON-LD/SEO tetap muncul karena di-render React di browser — cukup untuk
development. SSR baru wajib dites sebelum deploy (lihat bawah).

## Menjalankan Mode Production-like (dengan SSR)

Ini simulasi paling mendekati production, termasuk SSR yang wajib sesuai spec SEO:

```bash
npm run build              # build assets client + SSR bundle
php artisan inertia:start-ssr &   # jalankan proses Node SSR di background
php artisan serve
```

Cek SSR bekerja: `view-source:` halaman manapun harus sudah berisi konten lengkap +
`<script type="application/ld+json">`, bukan `<div id="app"></div>` kosong.

Untuk mematikan proses SSR: `pkill -f inertia:start-ssr`.

## Mengisi Konten

Login ke `/admin`, lalu isi lewat menu:
- **Pengaturan** — identitas Reza & Linktown, nomor WhatsApp, social media, disclaimer
- **Produk** — listing rumah/ruko/kavling + galeri foto
- **Artikel** — tips/info kawasan

## Struktur Penting

- `routes/web.php` — route halaman publik
- `app/Http/Controllers/` — controller yang mengirim data + SEO/JSON-LD ke Inertia
- `resources/js/Pages/` — halaman React (Home, About, Produk, Artikel)
- `app/Filament/` — resource & halaman admin panel
- `/sitemap.xml` — auto-generate dari Produk & Artikel yang published

## Deploy ke VPS (ringkas)

1. `composer install --no-dev --optimize-autoloader`
2. `npm ci && npm run build`
3. `.env` production: set `DB_CONNECTION=mysql` + kredensial, `APP_ENV=production`, `APP_DEBUG=false`
4. `php artisan migrate --force`
5. Jalankan proses SSR (`php artisan inertia:start-ssr`) tetap hidup pakai Supervisor/PM2 — ini
   proses terpisah dari PHP-FPM, jangan lupa masuk ke checklist deployment.
6. Setup SSL (Let's Encrypt).
