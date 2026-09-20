<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\TipeUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TipeUnit>
 */
class TipeUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $luasTanah = $this->faker->numberBetween(60, 200);
        $luasBangunan = $this->faker->numberBetween(36, 150);

        return [
            'produk_id' => Produk::factory(),
            'nama_tipe' => "Tipe {$luasBangunan}/{$luasTanah}",
            'luas_tanah' => $luasTanah,
            'luas_bangunan' => $luasBangunan,
            'kamar_tidur' => $this->faker->numberBetween(2, 4),
            'kamar_mandi' => $this->faker->numberBetween(1, 3),
            'carport' => $this->faker->optional(0.6)->numberBetween(1, 2),
            'jumlah_lantai' => $this->faker->optional(0.3)->numberBetween(2, 3),
            'urutan' => 0,
        ];
    }

    /**
     * Untuk ruko: luas tanah/bangunan + jumlah lantai wajib, tanpa kamar tidur.
     */
    public function ruko(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'nama_tipe' => "Ruko {$attributes['luas_bangunan']}/{$attributes['luas_tanah']}",
                'kamar_tidur' => null,
                'kamar_mandi' => $this->faker->numberBetween(1, 2),
                'jumlah_lantai' => $this->faker->numberBetween(2, 4),
                'carport' => $this->faker->optional(0.5)->numberBetween(1, 2),
            ];
        });
    }

    /**
     * Untuk apartment: luas unit + tipe kamar (0=Studio, 1=1BR, dst.), tanpa luas tanah/carport/lantai.
     */
    public function apartment(): static
    {
        return $this->state(function (array $attributes) {
            $tipeKamar = $this->faker->numberBetween(0, 2);

            return [
                'nama_tipe' => $tipeKamar === 0 ? 'Studio' : "{$tipeKamar}BR",
                'luas_tanah' => null,
                'luas_bangunan' => $this->faker->numberBetween(24, 80),
                'kamar_tidur' => $tipeKamar,
                'kamar_mandi' => 1,
                'carport' => null,
                'jumlah_lantai' => null,
            ];
        });
    }

    /**
     * Untuk kavling/gudang: cuma luas tanah, tanpa spesifikasi bangunan.
     */
    public function tanpaBangunan(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'nama_tipe' => "Unit {$attributes['luas_tanah']} m²",
                'luas_bangunan' => null,
                'kamar_tidur' => null,
                'kamar_mandi' => null,
                'carport' => null,
                'jumlah_lantai' => null,
            ];
        });
    }
}
