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

        // Operator Sekolah
        User::create([
            'name' => 'Seko',
            'email' => 'sekolah@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Kepala SDN 2',
            'email' => 'sdn2@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Kepala SDN 3',
            'email' => 'sdn3@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Kepala SDN 4',
            'email' => 'sdn4@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'Kepala SDN 5',
            'email' => 'sdn5@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        // Operator SPPG
        User::create([
            'name' => 'Espe',
            'email' => 'sppg@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'SPPG Jakarta Selatan',
            'email' => 'sppg-jaksel@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);

        User::create([
            'name' => 'SPPG Jakarta Timur',
            'email' => 'sppg-jaktim@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);
    }
}
