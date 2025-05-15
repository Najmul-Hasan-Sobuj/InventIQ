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
        $transactions = [
            [
                'type' => 'in',
                'quantity' => fake()->numberBetween(5, 20),
                'notes' => 'Initial stock received from supplier'
            ],
            [
                'type' => 'in',
                'quantity' => fake()->numberBetween(1, 10),
                'notes' => 'Restock from warehouse'
            ],
            [
                'type' => 'out',
                'quantity' => fake()->numberBetween(1, 5),
                'notes' => 'Regular customer order'
            ],
            [
                'type' => 'out',
                'quantity' => fake()->numberBetween(1, 3),
                'notes' => 'Online store order'
            ],
            [
                'type' => 'in',
                'quantity' => fake()->numberBetween(2, 8),
                'notes' => 'Return from customer - good condition'
            ],
            [
                'type' => 'out',
                'quantity' => fake()->numberBetween(1, 4),
                'notes' => 'Bulk order for corporate client'
            ],
            [
                'type' => 'in',
                'quantity' => fake()->numberBetween(3, 15),
                'notes' => 'New shipment from manufacturer'
            ],
            [
                'type' => 'out',
                'quantity' => fake()->numberBetween(1, 2),
                'notes' => 'Store display unit'
            ]
        ];

        $transaction = fake()->randomElement($transactions);
        
        return [
            'product_id' => null, // This will be set in the seeder
            'type' => $transaction['type'],
            'quantity' => $transaction['quantity'],
            'notes' => $transaction['notes'],
        ];
    }
}
