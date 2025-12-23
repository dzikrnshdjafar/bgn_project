<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DapurSehat;
use App\Models\JadwalMenu;
use App\Models\Makanan;
use App\Models\KategoriMakanan;

class JadwalMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all SPPG
        $dapurSehats = DapurSehat::all();

        // Get kategori
        $karbohidrat = KategoriMakanan::where('nama_kategori', 'Karbohidrat')->first();
        $proteinHewani = KategoriMakanan::where('nama_kategori', 'Protein Hewani')->first();
        $proteinNabati = KategoriMakanan::where('nama_kategori', 'Protein Nabati')->first();
        $sayuran = KategoriMakanan::where('nama_kategori', 'Sayuran')->first();
        $buahPelengkap = KategoriMakanan::where('nama_kategori', 'Buah & Pelengkap')->first();

        // Get all makanan per kategori
        $karbohidrats = Makanan::where('kategori_makanan_id', $karbohidrat?->id)->get();
        $proteinHewanis = Makanan::where('kategori_makanan_id', $proteinHewani?->id)->get();
        $proteinNabatis = Makanan::where('kategori_makanan_id', $proteinNabati?->id)->get();
        $sayurans = Makanan::where('kategori_makanan_id', $sayuran?->id)->get();
        $buahPelengkaps = Makanan::where('kategori_makanan_id', $buahPelengkap?->id)->get();

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($dapurSehats as $index => $dapurSehat) {
            foreach ($hari as $hariIndex => $namaHari) {
                // Create jadwal menu
                $jadwalMenu = JadwalMenu::create([
                    'dapur_sehat_id' => $dapurSehat->id,
                    'hari' => $namaHari,
                    'keterangan' => 'Menu ' . $namaHari . ' - ' . $dapurSehat->nama_dapur,
                ]);

                // Attach makanan untuk setiap jadwal menu
                // Gunakan kombinasi yang berbeda untuk setiap SPPG dan hari
                $combinationIndex = ($index * 5 + $hariIndex) % 3; // Variasi 3 kombinasi

                // Karbohidrat - pilih 1
                if ($karbohidrats->count() > 0) {
                    $selectedKarbo = $karbohidrats->get($hariIndex % $karbohidrats->count());
                    $jadwalMenu->makanans()->attach($selectedKarbo->id);
                }

                // Protein Hewani - pilih 1
                if ($proteinHewanis->count() > 0) {
                    $selectedProteinHewani = $proteinHewanis->get(($hariIndex + $combinationIndex) % $proteinHewanis->count());
                    $jadwalMenu->makanans()->attach($selectedProteinHewani->id);
                }

                // Protein Nabati - pilih 1
                if ($proteinNabatis->count() > 0) {
                    $selectedProteinNabati = $proteinNabatis->get(($hariIndex + $combinationIndex + 1) % $proteinNabatis->count());
                    $jadwalMenu->makanans()->attach($selectedProteinNabati->id);
                }

                // Sayuran - pilih 1
                if ($sayurans->count() > 0) {
                    $selectedSayur = $sayurans->get(($hariIndex + $combinationIndex + 2) % $sayurans->count());
                    $jadwalMenu->makanans()->attach($selectedSayur->id);
                }

                // Buah & Pelengkap - pilih 1
                if ($buahPelengkaps->count() > 0) {
                    $selectedBuah = $buahPelengkaps->get(($hariIndex + $combinationIndex) % $buahPelengkaps->count());
                    $jadwalMenu->makanans()->attach($selectedBuah->id);
                }
            }
        }
    }
}
