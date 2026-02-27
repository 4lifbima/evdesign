<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['name' => 'Benang Sulam', 'slug' => 'benang-sulam', 'category' => 'Benang', 'unit' => 'roll', 'stock' => 120, 'minimum_stock' => 20, 'cost_per_unit' => 35000],
            ['name' => 'Kain Katun', 'slug' => 'kain-katun', 'category' => 'Kain', 'unit' => 'meter', 'stock' => 80, 'minimum_stock' => 15, 'cost_per_unit' => 60000],
            ['name' => 'Kain Satin', 'slug' => 'kain-satin', 'category' => 'Kain', 'unit' => 'meter', 'stock' => 40, 'minimum_stock' => 10, 'cost_per_unit' => 85000],
        ];

        foreach ($materials as $material) {
            Material::updateOrCreate(
                ['slug' => $material['slug']],
                $material + ['is_active' => true]
            );
        }
    }
}
