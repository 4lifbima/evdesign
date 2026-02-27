<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@evdesign.test'],
            [
                'name' => 'Admin EVDesign',
                'password' => 'password',
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
                'role' => 'staff',
                'is_active' => true,
            ]
        );

        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            ArtisanSeeder::class,
            MaterialSeeder::class,
            ProductSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
