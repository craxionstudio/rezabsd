<?php

namespace Database\Seeders;

use App\Models\Artikel;
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
            'bio' => 'Reza Alhadithia adalah sales marketing properti berpengalaman yang membantu banyak keluarga menemukan hunian yang tepat.',
        ]);

        Produk::factory(9)->create();
        Artikel::factory(6)->create();
    }
}
