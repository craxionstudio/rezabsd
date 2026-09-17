<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\TipeRumah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TipeRumah>
 */
class TipeRumahFactory extends Factory
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
            'urutan' => 0,
        ];
    }

    /**
     * For kavling/gudang: land only, no building or room specs.
     */
    public function tanpaBangunan(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'nama_tipe' => "Unit {$attributes['luas_tanah']} m²",
                'luas_bangunan' => null,
                'kamar_tidur' => null,
                'kamar_mandi' => null,
            ];
        });
    }
}
