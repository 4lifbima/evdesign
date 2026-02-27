<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(10, 99),
            'description' => fake()->paragraph(),
            'short_description' => fake()->sentence(),
            'price' => fake()->numberBetween(150000, 3000000),
            'discount_price' => null,
            'stock' => fake()->numberBetween(1, 100),
            'sku' => 'SKU-'.strtoupper(fake()->bothify('??###')),
            'status' => fake()->randomElement(['draft', 'published', 'published']),
            'is_featured' => fake()->boolean(20),
            'is_best_seller' => fake()->boolean(15),
            'is_new' => fake()->boolean(30),
            'colors' => ['Merah', 'Hitam'],
            'sizes' => ['M', 'L'],
            'materials' => ['Katun'],
            'dimensions' => ['70x40'],
            'category_id' => Category::query()->inRandomOrder()->value('id'),
        ];
    }
}
