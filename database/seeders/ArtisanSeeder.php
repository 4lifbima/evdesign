<?php

namespace Database\Seeders;

use App\Models\Artisan;
use Illuminate\Database\Seeder;

class ArtisanSeeder extends Seeder
{
    public function run(): void
    {
        $target = 24;
        $current = Artisan::count();

        if ($current < $target) {
            Artisan::factory()->count($target - $current)->create();
        }
    }
}
