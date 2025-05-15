<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Home & Kitchen', 'description' => 'Home appliances and kitchenware'],
            ['name' => 'Books', 'description' => 'Books and publications'],
            ['name' => 'Sports & Outdoors', 'description' => 'Sports equipment and outdoor gear'],
            ['name' => 'Beauty & Personal Care', 'description' => 'Beauty products and personal care items'],
            ['name' => 'Toys & Games', 'description' => 'Toys, games, and entertainment'],
            ['name' => 'Automotive', 'description' => 'Automotive parts and accessories'],
            ['name' => 'Health & Household', 'description' => 'Health products and household items'],
            ['name' => 'Office Products', 'description' => 'Office supplies and equipment']
        ];

        $category = fake()->unique()->randomElement($categories);
        
        return [
            'name' => $category['name'],
            'description' => $category['description'],
        ];
    }
}
