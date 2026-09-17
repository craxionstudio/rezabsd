<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\TipeProduk;
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
        $tipe = TipeProduk::query()->inRandomOrder()->first() ?? TipeProduk::factory()->create();
        $tipeSlug = $tipe->slug;
        $blok = strtoupper($this->faker->randomLetter());
        $nomor = $this->faker->numberBetween(1, 40);
        $nama = match ($tipeSlug) {
            'rumah' => "Rumah Tipe {$this->faker->numberBetween(36, 90)}/{$this->faker->numberBetween(60, 120)} - Blok {$blok}{$nomor}",
            'ruko' => "Ruko 2 Lantai - Blok {$blok}{$nomor}",
            'gudang' => "Gudang Siap Pakai - Blok {$blok}{$nomor}",
            default => "Kavling Siap Bangun - Blok {$blok}{$nomor}",
        };
        $tanpaBangunan = in_array($tipeSlug, ['kavling', 'gudang']);

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'tipe_produk_id' => $tipe->id,
            'status' => $this->faker->randomElement(['primary', 'secondary']),
            'listing_type' => $this->faker->randomElement(['jual', 'jual', 'jual', 'sewa']),
            'harga' => $this->faker->numberBetween(400, 2500) * 1_000_000,
            'luas_tanah' => $this->faker->numberBetween(60, 200),
            'luas_bangunan' => $tanpaBangunan ? null : $this->faker->numberBetween(45, 150),
            'kamar_tidur' => $tanpaBangunan ? null : $this->faker->numberBetween(2, 4),
            'kamar_mandi' => $tanpaBangunan ? null : $this->faker->numberBetween(1, 3),
            'deskripsi' => '<p>'.$this->faker->paragraphs(3, true).'</p>',
            'lokasi' => $this->faker->randomElement(['Kawasan Utara', 'Kawasan Selatan', 'Kawasan Tengah']),
            'status_tayang' => 'published',
        ];
    }
}
