<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Karbohidrat',
                'keterangan' => 'Makanan sumber karbohidrat seperti nasi, mie, roti, dll',
            ],
            [
                'nama_kategori' => 'Protein Hewani',
                'keterangan' => 'Makanan sumber protein hewani seperti daging, ikan, telur, dll',
            ],
            [
                'nama_kategori' => 'Sayur',
                'keterangan' => 'Berbagai jenis sayuran untuk kebutuhan nutrisi',
            ],
            [
                'nama_kategori' => 'Protein Nabati',
                'keterangan' => 'Makanan sumber protein nabati seperti tahu, tempe, kacang-kacangan, dll',
            ],
            [
                'nama_kategori' => 'Buah/Pelengkap',
                'keterangan' => 'Buah-buahan dan makanan pelengkap lainnya',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriMenu::create($kategori);
        }
    }
}
