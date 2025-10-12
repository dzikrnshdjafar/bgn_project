<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Atmint',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Bege',
            'email' => 'bgn@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Seko',
            'email' => 'sekolah@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Espe',
            'email' => 'sppg@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);
    }
}
