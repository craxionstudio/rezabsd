<?php

namespace Database\Factories;

use App\Models\KategoriArtikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<KategoriArtikel>
 */
class KategoriArtikelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->unique()->randomElement([
            'Tips Beli Rumah', 'Info Kawasan', 'Simulasi KPR', 'Legal & Perizinan',
        ]);

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'deskripsi_singkat' => $this->faker->sentence(12),
            'urutan' => 0,
        ];
    }
}
