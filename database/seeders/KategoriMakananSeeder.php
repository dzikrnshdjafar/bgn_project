<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriMakanan;

class KategoriMakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Karbohidrat',
                'deskripsi' => 'Makanan pokok sumber karbohidrat dan energi'
            ],
            [
                'nama_kategori' => 'Protein Hewani',
                'deskripsi' => 'Lauk utama dari sumber protein hewani'
            ],
            [
                'nama_kategori' => 'Protein Nabati',
                'deskripsi' => 'Lauk pendamping dari sumber protein nabati'
            ],
            [
                'nama_kategori' => 'Sayuran',
                'deskripsi' => 'Sayuran sumber vitamin, mineral, dan serat'
            ],
            [
                'nama_kategori' => 'Buah & Pelengkap',
                'deskripsi' => 'Buah-buahan dan pelengkap nutrisi'
            ],
        ];

        foreach ($categories as $category) {
            KategoriMakanan::create($category);
        }
    }
}
