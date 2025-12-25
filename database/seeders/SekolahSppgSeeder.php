<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Sppg;
use Illuminate\Database\Seeder;

class SekolahSppgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all SPPG and Sekolah
        $sppgs = Sppg::all();
        $sekolahs = Sekolah::all();

        if ($sppgs->count() > 0 && $sekolahs->count() > 0) {
            // Assign schools to SPPG with zones
            // Now using one-to-many relationship: 1 sekolah belongs to 1 SPPG
            // But 1 SPPG can have multiple sekolahs

            // SPPG 1 (Pusat) -> Sekolah 1 dan Sekolah 2 (both in Pusat)
            if ($sppgs->count() >= 1 && $sekolahs->count() >= 1) {
                $sekolahs[0]->update([
                    'sppg_id' => $sppgs[0]->id,
                ]);
            }

            if ($sppgs->count() >= 1 && $sekolahs->count() >= 2) {
                $sekolahs[1]->update([
                    'sppg_id' => $sppgs[0]->id,
                ]);
            }

            // SPPG 2 (Utara) -> Sekolah 3 (Utara)
            if ($sppgs->count() >= 2 && $sekolahs->count() >= 3) {
                $sekolahs[2]->update([
                    'sppg_id' => $sppgs[1]->id,
                ]);
            }

            // SPPG 3 (Selatan) has no schools yet (to demonstrate)
        }
    }
}
