<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Artikel>
 */
class ArtikelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->sentence(6);

        return [
            'judul' => $judul,
            'slug' => Str::slug($judul).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'konten' => '<p>'.$this->faker->paragraphs(5, true).'</p>',
            'kategori' => $this->faker->randomElement(['Tips Beli Rumah', 'Info Kawasan', 'KPR & Pembiayaan']),
            'tanggal_publish' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'status_tayang' => 'published',
        ];
    }
}
