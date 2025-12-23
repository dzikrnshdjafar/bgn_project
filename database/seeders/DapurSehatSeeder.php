<?php

namespace Database\Seeders;

use App\Models\DapurSehat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DapurSehatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SPPG Jakarta Pusat
        $userSppg1 = User::where('email', 'sppg@gmail.com')->first();
        if ($userSppg1) {
            DapurSehat::create([
                'user_id' => $userSppg1->id,
                'nama_dapur' => 'Dapur Sehat Jakarta Pusat',
                'alamat' => 'Jl. Tanah Abang No. 10, Jakarta Pusat',
            ]);
        }

        // SPPG Jakarta Selatan
        $userSppg2 = User::where('email', 'sppg-jaksel@gmail.com')->first();
        if ($userSppg2) {
            DapurSehat::create([
                'user_id' => $userSppg2->id,
                'nama_dapur' => 'Dapur Sehat Jakarta Selatan',
                'alamat' => 'Jl. Fatmawati No. 25, Jakarta Selatan',
            ]);
        }

        // SPPG Jakarta Timur
        $userSppg3 = User::where('email', 'sppg-jaktim@gmail.com')->first();
        if ($userSppg3) {
            DapurSehat::create([
                'user_id' => $userSppg3->id,
                'nama_dapur' => 'Dapur Sehat Jakarta Timur',
                'alamat' => 'Jl. Cililitan No. 15, Jakarta Timur',
            ]);
        }
    }
}
