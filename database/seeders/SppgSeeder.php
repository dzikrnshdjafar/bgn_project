<?php

namespace Database\Seeders;

use App\Models\Sppg;
use App\Models\User;
use Illuminate\Database\Seeder;

class SppgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users for SPPG first
        $sppgUsers = [
            [
                'name' => 'Dapur Pusat Jakarta',
                'email' => 'sppg1@gmail.com',
                'password' => bcrypt('asdasdasd'),
            ],
            [
                'name' => 'Dapur Utara Jakarta',
                'email' => 'sppg2@gmail.com',
                'password' => bcrypt('asdasdasd'),
            ],
            [
                'name' => 'Dapur Selatan Jakarta',
                'email' => 'sppg3@gmail.com',
                'password' => bcrypt('asdasdasd'),
            ],
        ];

        $sppgs = [
            [
                'nama_dapur' => 'Dapur Pusat Jakarta',
                'alamat' => 'Jl. Gatot Subroto No. 15, Jakarta Pusat',
            ],
            [
                'nama_dapur' => 'Dapur Utara Jakarta',
                'alamat' => 'Jl. Yos Sudarso No. 30, Jakarta Utara',
            ],
            [
                'nama_dapur' => 'Dapur Selatan Jakarta',
                'alamat' => 'Jl. TB Simatupang No. 50, Jakarta Selatan',
            ],
        ];

        foreach ($sppgUsers as $index => $userData) {
            // Create user
            $user = User::create($userData);

            // Assign role
            $user->assignRole('Operator SPPG');

            // Create sppg data
            Sppg::create([
                'user_id' => $user->id,
                'nama_dapur' => $sppgs[$index]['nama_dapur'],
                'alamat' => $sppgs[$index]['alamat'],
            ]);
        }
    }
}
