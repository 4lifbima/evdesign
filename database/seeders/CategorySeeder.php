<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'SIMLYCITY',
                'description' => 'Koleksi pakaian dengan desain clean dan minimalis',
                'icon' => 'solar:tshirt-linear',
            ],
            [
                'name' => 'MODESTY',
                'description' => 'Koleksi pakaian sopan dan tertutup dengan sentuhan modern',
                'icon' => 'solar:hanger-linear',
            ],
            [
                'name' => 'SULAMAN',
                'description' => 'Koleksi eksklusif dengan sulaman Karawo',
                'icon' => 'solar:magic-stick-3-linear',
            ]
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => str($cat['name'])->slug()],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'icon' => $cat['icon'],
                    'parent_id' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
