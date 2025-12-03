<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user with Operator Sekolah role
        $userSekolah = User::where('email', 'sekolah@gmail.com')->first();

        if ($userSekolah) {
            Sekolah::create([
                'user_id' => $userSekolah->id,
                'nama_sekolah' => 'SDN 1 Jakarta Pusat',
                'alamat_sekolah' => 'Jl. Medan Merdeka No. 1, Jakarta Pusat',
                'jumlah_siswa' => 150,
            ]);
        }
    }
}
