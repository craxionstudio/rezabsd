<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use App\Models\Artikel;
use App\Models\HomeContent;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        Setting::query()->firstOrCreate([], [
            'nama_sales' => 'Reza Alhadithia',
            'jabatan' => 'Sales Marketing Properti',
            'nama_agensi' => 'Linktown',
            'whatsapp' => '6281234567890',
            'email' => 'reza@linktown.example',
            'alamat_agensi' => 'Kantor Pemasaran Linktown',
            'instagram' => 'https://instagram.com/username_reza',
        ]);

        HomeContent::query()->firstOrCreate([], [
            'hero_eyebrow' => 'Sales properti Linktown — kawasan ini',
            'hero_headline' => 'Temukan rumah yang terasa seperti *pulang*',
            'hero_subtext' => 'Reza bantu Anda cari rumah, ruko, atau kavling primary dan secondary di kawasan ini — dari konsultasi awal sampai serah terima kunci.',
            'hero_cta_label' => 'Lihat listing',
            'stat_1_value' => '50+',
            'stat_1_label' => 'Unit terjual',
            'stat_2_value' => '5',
            'stat_2_label' => 'Tahun pengalaman',
            'stat_3_value' => '4.9',
            'stat_3_label' => 'Rating klien dari 5',
            'process_step_1_title' => 'Konsultasi kebutuhan',
            'process_step_1_desc' => 'Cerita budget, tipe unit, dan target waktu — Reza bantu petakan opsi yang cocok.',
            'process_step_2_title' => 'Survei & rekomendasi',
            'process_step_2_desc' => 'Kunjungi unit langsung, bandingkan pilihan primary dan secondary di kawasan ini.',
            'process_step_3_title' => 'Proses closing',
            'process_step_3_desc' => 'Reza dampingi sampai administrasi kelar dan kunci di tangan Anda.',
            'testimonial_quote' => 'Dibantu dari awal cari unit sampai deal, prosesnya jelas dan nggak buru-buru.',
            'testimonial_name' => 'Budi Santoso',
            'cta_banner_title' => 'Siap cari unit yang pas?',
            'cta_banner_subtitle' => 'Konsultasi gratis, Reza bantu petakan pilihan sesuai budget dan kebutuhan Anda.',
            'cta_banner_button_label' => 'Chat via WhatsApp',
        ]);

        AboutContent::query()->firstOrCreate([], [
            'hero_headline' => 'Halo, saya Reza — bantu Anda cari unit yang *pas*',
            'hero_subtext' => 'Lima tahun fokus di kawasan ini, dari unit primary langsung dari pengembang sampai secondary dari pemilik lama. Saya pegang sendiri tiap konsultasi, bukan dilempar ke tim lain.',
            'bio_paragraph_1' => 'Saya mulai di dunia properti tahun 2021, awalnya bantu keluarga cari rumah pertama mereka. Dari situ saya sadar banyak orang bingung bedanya unit primary dan secondary, atau ragu karena nggak tahu harus percaya siapa.',
            'bio_paragraph_2' => 'Sekarang saya fokus di kawasan ini saja — bukan asal jual semua listing yang ada, tapi benar-benar paham tiap blok, harga pasarannya, dan riwayat unitnya.',
            'credential_afiliasi' => 'Linktown — agen properti',
            'credential_area' => 'Kawasan ini saja',
            'credential_pengalaman' => '5 tahun, 50+ unit terjual',
            'credential_kontak' => '0812-xxxx-xxxx',
            'linktown_description' => 'Linktown adalah agen properti tempat saya bernaung. Bukan pengembang, bukan pengelola kawasan — perannya menghubungkan pembeli dengan unit primary dari pengembang maupun secondary dari pemilik lama, lewat sales seperti saya yang pegang area tertentu.',
        ]);

        Produk::factory(9)->create();
        Artikel::factory(6)->create();
    }
}
