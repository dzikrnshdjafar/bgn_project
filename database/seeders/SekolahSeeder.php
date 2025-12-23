<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use App\Models\DapurSehat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get SPPG
        $sppgJakpus = DapurSehat::where('nama_dapur', 'Dapur Sehat Jakarta Pusat')->first();
        $sppgJaksel = DapurSehat::where('nama_dapur', 'Dapur Sehat Jakarta Selatan')->first();
        $sppgJaktim = DapurSehat::where('nama_dapur', 'Dapur Sehat Jakarta Timur')->first();

        // Sekolah 1 - Jakarta Pusat (assigned to SPPG Jakarta Pusat)
        $userSekolah1 = User::where('email', 'sekolah@gmail.com')->first();
        if ($userSekolah1) {
            Sekolah::create([
                'user_id' => $userSekolah1->id,
                'dapur_sehat_id' => $sppgJakpus?->id,
                'nama_sekolah' => 'SDN 1 Jakarta Pusat',
                'alamat_sekolah' => 'Jl. Medan Merdeka No. 1, Jakarta Pusat',
                'jumlah_siswa' => 150,
            ]);
        }

        // Sekolah 2 - Jakarta Pusat (assigned to SPPG Jakarta Pusat)
        $userSekolah2 = User::where('email', 'sdn2@gmail.com')->first();
        if ($userSekolah2) {
            Sekolah::create([
                'user_id' => $userSekolah2->id,
                'dapur_sehat_id' => $sppgJakpus?->id,
                'nama_sekolah' => 'SDN 2 Menteng',
                'alamat_sekolah' => 'Jl. Menteng Raya No. 45, Jakarta Pusat',
                'jumlah_siswa' => 200,
            ]);
        }

        // Sekolah 3 - Jakarta Selatan (assigned to SPPG Jakarta Selatan)
        $userSekolah3 = User::where('email', 'sdn3@gmail.com')->first();
        if ($userSekolah3) {
            Sekolah::create([
                'user_id' => $userSekolah3->id,
                'dapur_sehat_id' => $sppgJaksel?->id,
                'nama_sekolah' => 'SDN 3 Kebayoran',
                'alamat_sekolah' => 'Jl. Kebayoran Lama No. 88, Jakarta Selatan',
                'jumlah_siswa' => 180,
            ]);
        }

        // Sekolah 4 - Jakarta Timur (assigned to SPPG Jakarta Timur)
        $userSekolah4 = User::where('email', 'sdn4@gmail.com')->first();
        if ($userSekolah4) {
            Sekolah::create([
                'user_id' => $userSekolah4->id,
                'dapur_sehat_id' => $sppgJaktim?->id,
                'nama_sekolah' => 'SDN 4 Kramat Jati',
                'alamat_sekolah' => 'Jl. Kramat Jati No. 12, Jakarta Timur',
                'jumlah_siswa' => 165,
            ]);
        }

        // Sekolah 5 - Belum assigned ke SPPG manapun
        $userSekolah5 = User::where('email', 'sdn5@gmail.com')->first();
        if ($userSekolah5) {
            Sekolah::create([
                'user_id' => $userSekolah5->id,
                'dapur_sehat_id' => null,
                'nama_sekolah' => 'SDN 5 Cempaka Putih',
                'alamat_sekolah' => 'Jl. Cempaka Putih No. 77, Jakarta Pusat',
                'jumlah_siswa' => 120,
            ]);
        }
    }
}
