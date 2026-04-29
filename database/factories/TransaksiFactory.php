<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaksi>
 */
class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition(): array
    {
        return [
            'product_name' => fake()->words(3, true),
            'quantity' => fake()->numberBetween(1, 10),
            'total' => fake()->randomFloat(2, 20, 500),
            'status' => fake()->randomElement(['pending', 'paid', 'completed']),
        ];
    }
}
