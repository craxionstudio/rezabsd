<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipe = $this->faker->randomElement(['rumah', 'ruko', 'kavling']);
        $blok = strtoupper($this->faker->randomLetter());
        $nomor = $this->faker->numberBetween(1, 40);
        $nama = match ($tipe) {
            'rumah' => "Rumah Tipe {$this->faker->numberBetween(36, 90)}/{$this->faker->numberBetween(60, 120)} - Blok {$blok}{$nomor}",
            'ruko' => "Ruko 2 Lantai - Blok {$blok}{$nomor}",
            'kavling' => "Kavling Siap Bangun - Blok {$blok}{$nomor}",
        };

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'tipe' => $tipe,
            'status' => $this->faker->randomElement(['primary', 'secondary']),
            'harga' => $this->faker->numberBetween(400, 2500) * 1_000_000,
            'luas_tanah' => $this->faker->numberBetween(60, 200),
            'luas_bangunan' => $tipe === 'kavling' ? null : $this->faker->numberBetween(45, 150),
            'kamar_tidur' => $tipe === 'kavling' ? null : $this->faker->numberBetween(2, 4),
            'kamar_mandi' => $tipe === 'kavling' ? null : $this->faker->numberBetween(1, 3),
            'deskripsi' => '<p>'.$this->faker->paragraphs(3, true).'</p>',
            'lokasi' => $this->faker->randomElement(['Kawasan Utara', 'Kawasan Selatan', 'Kawasan Tengah']),
            'status_tayang' => 'published',
        ];
    }
}
