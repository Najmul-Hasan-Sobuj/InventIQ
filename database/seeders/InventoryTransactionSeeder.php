<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\Product::all();
        
        foreach ($products as $product) {
            \App\Models\InventoryTransaction::factory(3)->create([
                'product_id' => $product->id
            ]);
        }
    }
}
