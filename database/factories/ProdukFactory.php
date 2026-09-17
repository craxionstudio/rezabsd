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
        $cluster = $this->faker->randomElement(['Eonna', 'Vasanta', 'Anara', 'Talia', 'Nara Hills', 'Serena']);
        $kawasan = $this->faker->randomElement(['BSD', 'Serpong', 'Cibubur', 'Bintaro']);
        $nama = match ($tipeSlug) {
            'ruko' => "{$cluster} Commercial Park",
            'gudang' => "{$cluster} Logistics Hub",
            'kavling' => "{$cluster} Land Estate",
            default => "{$cluster} {$kawasan}",
        };

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'tipe_produk_id' => $tipe->id,
            'status' => $this->faker->randomElement(['primary', 'secondary']),
            'listing_type' => $this->faker->randomElement(['jual', 'jual', 'jual', 'sewa']),
            'harga' => $this->faker->numberBetween(400, 2500) * 1_000_000,
            'deskripsi' => '<p>'.$this->faker->paragraphs(3, true).'</p>',
            'lokasi' => $this->faker->randomElement(['Kawasan Utara', 'Kawasan Selatan', 'Kawasan Tengah']),
            'status_tayang' => 'published',
        ];
    }
}
