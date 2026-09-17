<?php

namespace Database\Factories;

use App\Models\TipeProduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TipeProduk>
 */
class TipeProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->unique()->word();

        return [
            'nama' => ucfirst($nama),
            'slug' => Str::slug($nama),
            'urutan' => 0,
        ];
    }
}
