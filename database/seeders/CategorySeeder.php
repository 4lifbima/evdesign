<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $parent = Category::updateOrCreate(
            ['slug' => 'ready-to-wear'],
            [
                'name' => 'Ready to Wear',
                'description' => 'Koleksi pakaian siap pakai dengan sentuhan sulaman Karawo',
                'icon' => 'solar:tshirt-linear',
                'is_active' => true,
            ]
        );

        foreach (['Kemeja', 'Celana Boim', 'Jacket', 'Outer', 'Jas', 'Gaun Malam'] as $name) {
            Category::updateOrCreate(
                ['slug' => str($name)->slug()],
                [
                    'name' => $name,
                    'parent_id' => $parent->id,
                    'is_active' => true,
                ]
            );
        }

        Category::updateOrCreate(
            ['slug' => 'bahan-sulaman'],
            [
                'name' => 'Bahan Sulaman',
                'description' => 'Bahan kain dengan sulaman Karawo siap pakai',
                'icon' => 'solar:box-linear',
                'is_active' => true,
            ]
        );
    }
}
