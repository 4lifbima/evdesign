<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::query()->exists()) {
            return;
        }

        Product::factory()->count(15)->create()->each(function (Product $product): void {
            $product->images()->create([
                'image_path' => 'products/default.jpg',
                'is_primary' => true,
                'sort_order' => 0,
            ]);
            $product->variants()->create([
                'name' => $product->name.' - Merah - M',
                'color' => 'Merah',
                'size' => 'M',
                'price' => $product->price,
                'stock' => rand(1, 20),
                'is_active' => true,
            ]);
        });
    }
}
