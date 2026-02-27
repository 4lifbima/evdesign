<?php

namespace Database\Factories;

use App\Models\Artisan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Artisan>
 */
class ArtisanFactory extends Factory
{
    protected $model = Artisan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => Str::slug(fake()->unique()->name()).'-'.fake()->unique()->numberBetween(10, 99),
            'photo' => 'artisans/placeholder-'.fake()->numberBetween(1, 8).'.jpg',
            'bio' => fake()->paragraph(),
            'address' => fake()->address(),
            'village' => fake()->streetName(),
            'district' => fake()->citySuffix(),
            'city' => 'Kabupaten Gorontalo',
            'province' => 'Gorontalo',
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'status' => fake()->randomElement(['active', 'active', 'inactive', 'on_leave']),
            'joined_date' => fake()->dateTimeBetween('-3 years', 'now'),
            'skills' => ['sulaman', 'menjahit', 'desain'],
        ];
    }
}
