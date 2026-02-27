<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['karawo', 'premium', 'baru', 'limited', 'best-seller'] as $name) {
            Tag::updateOrCreate(
                ['slug' => $name],
                ['name' => str($name)->title()]
            );
        }
    }
}
