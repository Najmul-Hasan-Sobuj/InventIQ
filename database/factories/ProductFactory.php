<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Track used SKUs to ensure uniqueness
     */
    protected static array $usedSkus = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            [
                'name' => 'iPhone 13 Pro',
                'sku' => 'IP13P-256-BLK',
                'description' => 'Apple iPhone 13 Pro 256GB Black',
                'price' => 999.99,
                'quantity' => fake()->numberBetween(5, 50)
            ],
            [
                'name' => 'Samsung 4K Smart TV',
                'sku' => 'SS-TV-55-4K',
                'description' => 'Samsung 55-inch 4K Smart LED TV',
                'price' => 799.99,
                'quantity' => fake()->numberBetween(5, 30)
            ],
            [
                'name' => 'Nike Air Max',
                'sku' => 'NK-AM-270-BLK',
                'description' => 'Nike Air Max 270 Black Running Shoes',
                'price' => 129.99,
                'quantity' => fake()->numberBetween(10, 100)
            ],
            [
                'name' => 'KitchenAid Mixer',
                'sku' => 'KA-MX-PRO',
                'description' => 'KitchenAid Professional 5qt Stand Mixer',
                'price' => 349.99,
                'quantity' => fake()->numberBetween(3, 20)
            ],
            [
                'name' => 'Dell XPS Laptop',
                'sku' => 'DL-XPS-15',
                'description' => 'Dell XPS 15 15.6" 4K Touch Laptop',
                'price' => 1499.99,
                'quantity' => fake()->numberBetween(2, 15)
            ],
            [
                'name' => 'Sony Headphones',
                'sku' => 'SN-WH-1000XM4',
                'description' => 'Sony WH-1000XM4 Wireless Noise Cancelling Headphones',
                'price' => 279.99,
                'quantity' => fake()->numberBetween(5, 40)
            ],
            [
                'name' => 'Dyson Vacuum',
                'sku' => 'DY-V11-AB',
                'description' => 'Dyson V11 Absolute Cordless Vacuum',
                'price' => 599.99,
                'quantity' => fake()->numberBetween(2, 10)
            ],
            [
                'name' => 'Canon Camera',
                'sku' => 'CN-EOS-R6',
                'description' => 'Canon EOS R6 Mirrorless Camera',
                'price' => 2499.99,
                'quantity' => fake()->numberBetween(1, 8)
            ],
            [
                'name' => 'Vitamix Blender',
                'sku' => 'VT-5200-PRO',
                'description' => 'Vitamix 5200 Professional Series Blender',
                'price' => 449.99,
                'quantity' => fake()->numberBetween(3, 25)
            ],
            [
                'name' => 'Apple Watch',
                'sku' => 'AP-W-S7-45',
                'description' => 'Apple Watch Series 7 45mm GPS',
                'price' => 399.99,
                'quantity' => fake()->numberBetween(5, 35)
            ]
        ];

        // Filter out products with already used SKUs
        $availableProducts = array_filter($products, function($product) {
            return !in_array($product['sku'], self::$usedSkus);
        });

        // If all SKUs are used, generate a new unique SKU
        if (empty($availableProducts)) {
            $baseProduct = fake()->randomElement($products);
            $newSku = $baseProduct['sku'] . '-' . fake()->unique()->numberBetween(1000, 9999);
            self::$usedSkus[] = $newSku;
            
            return [
                'name' => $baseProduct['name'],
                'sku' => $newSku,
                'description' => $baseProduct['description'],
                'price' => $baseProduct['price'],
                'quantity' => $baseProduct['quantity'],
                'category_id' => null, // This will be set in the seeder
            ];
        }

        // Use an available product
        $product = fake()->randomElement($availableProducts);
        self::$usedSkus[] = $product['sku'];
        
        return [
            'name' => $product['name'],
            'sku' => $product['sku'],
            'description' => $product['description'],
            'price' => $product['price'],
            'quantity' => $product['quantity'],
            'category_id' => null, // This will be set in the seeder
        ];
    }
}
