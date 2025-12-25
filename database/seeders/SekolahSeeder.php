<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users for schools first
        $sekolahUsers = [
            [
                'name' => 'SDN 01 Jakarta Pusat',
                'email' => 'skl1@gmail.com',
                'password' => bcrypt('asdasdasd'),
            ],
            [
                'name' => 'SDN 02 Jakarta Pusat',
                'email' => 'skl2@gmail.com',
                'password' => bcrypt('asdasdasd'),
            ],
            [
                'name' => 'SDN 03 Jakarta Utara',
                'email' => 'skl3@gmail.com',
                'password' => bcrypt('asdasdasd'),
            ],
        ];

        $sekolahs = [
            [
                'nama_sekolah' => 'SDN 01 Jakarta Pusat',
                'alamat_sekolah' => 'Jl. Merdeka No. 10, Jakarta Pusat',
            ],
            [
                'nama_sekolah' => 'SDN 02 Jakarta Pusat',
                'alamat_sekolah' => 'Jl. Thamrin No. 15, Jakarta Pusat',
            ],
            [
                'nama_sekolah' => 'SDN 03 Jakarta Utara',
                'alamat_sekolah' => 'Jl. Kemerdekaan No. 25, Jakarta Utara',
            ],
        ];

        foreach ($sekolahUsers as $index => $userData) {
            // Create user
            $user = User::create($userData);

            // Assign role
            $user->assignRole('Operator Sekolah');

            // Create sekolah data
            Sekolah::create([
                'user_id' => $user->id,
                'nama_sekolah' => $sekolahs[$index]['nama_sekolah'],
                'alamat_sekolah' => $sekolahs[$index]['alamat_sekolah'],
            ]);
        }
    }
}
