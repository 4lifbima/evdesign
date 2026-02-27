<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => 'EVDesign', 'group' => 'company', 'type' => 'text', 'description' => 'Nama perusahaan'],
            ['key' => 'company_email', 'value' => 'help@evdesign.id', 'group' => 'company', 'type' => 'text', 'description' => 'Email perusahaan'],
            ['key' => 'company_phone', 'value' => '+6285798132505', 'group' => 'company', 'type' => 'text', 'description' => 'Telepon perusahaan'],
            ['key' => 'primary_color', 'value' => '#fc1919', 'group' => 'appearance', 'type' => 'text', 'description' => 'Warna utama'],
            ['key' => 'founded_year', 'value' => '2021', 'group' => 'company', 'type' => 'number', 'description' => 'Tahun berdiri'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
