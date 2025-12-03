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
        // Get user with Operator SPPG role
        $userSppg = User::where('email', 'sppg@gmail.com')->first();

        if ($userSppg) {
            DapurSehat::create([
                'user_id' => $userSppg->id,
                'nama_dapur' => 'Dapur Sehat Jakarta Pusat',
                'alamat' => 'Jl. Tanah Abang No. 10, Jakarta Pusat',
            ]);
        }
    }
}
