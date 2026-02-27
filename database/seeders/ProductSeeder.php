<?php

namespace Database\Seeders;

use App\Models\Artisan;
use App\Models\Material;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::query()->exists()) {
            return;
        }

        Product::factory()->count(15)->create()->each(function (Product $product): void {
            $product->tags()->sync(Tag::inRandomOrder()->limit(2)->pluck('id')->all());
            $product->artisans()->sync(
                Artisan::inRandomOrder()->limit(2)->pluck('id')->mapWithKeys(
                    fn ($id) => [$id => ['quantity_made' => rand(1, 20)]]
                )->all()
            );
            $product->materialsRelation()->sync(
                Material::inRandomOrder()->limit(2)->pluck('id')->mapWithKeys(
                    fn ($id) => [$id => ['quantity_used' => rand(1, 3), 'unit' => 'pcs']]
                )->all()
            );
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
