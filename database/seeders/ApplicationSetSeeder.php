<?php

namespace Database\Seeders;

use App\Models\ApplicationSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApplicationSet::create([
            'name' => 'Application One',
            'address' => '123 Main Street, Cityville',
            'brand_image' => 'brandImages/kz5zoKdvj2ShXJPKGMTf7TgaRbalmCUwXLoxOWyP.png',
            'email' => 'appone@example.com',
            'phone_number' => '+6281234567890',
            'facebook' => 'https://facebook.com/appone',
            'instagram' => 'https://instagram.com/appone',
            'twitter' => 'https://twitter.com/appone',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
