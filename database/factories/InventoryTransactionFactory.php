<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => null, // This will be set in the seeder
            'type' => fake()->randomElement(['in', 'out']),
            'quantity' => fake()->numberBetween(1, 50),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
