<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Makanan;
use App\Models\KategoriMakanan;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get kategori IDs
        $karbohidrat = KategoriMakanan::where('nama_kategori', 'Karbohidrat')->first();
        $proteinHewani = KategoriMakanan::where('nama_kategori', 'Protein Hewani')->first();
        $proteinNabati = KategoriMakanan::where('nama_kategori', 'Protein Nabati')->first();
        $sayuran = KategoriMakanan::where('nama_kategori', 'Sayuran')->first();
        $buahPelengkap = KategoriMakanan::where('nama_kategori', 'Buah & Pelengkap')->first();

        $makanans = [
            // Karbohidrat
            [
                'nama_makanan' => 'Nasi Putih',
                'deskripsi' => 'Nasi putih sebagai makanan pokok sumber karbohidrat',
                'kategori_makanan_id' => $karbohidrat?->id
            ],
            [
                'nama_makanan' => 'Roti',
                'deskripsi' => 'Roti sebagai alternatif makanan pokok',
                'kategori_makanan_id' => $karbohidrat?->id
            ],

            // Protein Hewani
            [
                'nama_makanan' => 'Ayam Goreng Bistik',
                'deskripsi' => 'Ayam goreng dengan bumbu bistik',
                'kategori_makanan_id' => $proteinHewani?->id
            ],
            [
                'nama_makanan' => 'Gulai Ayam',
                'deskripsi' => 'Ayam dengan kuah gulai khas Indonesia',
                'kategori_makanan_id' => $proteinHewani?->id
            ],
            [
                'nama_makanan' => 'Ayam Krispi',
                'deskripsi' => 'Ayam goreng tepung yang renyah',
                'kategori_makanan_id' => $proteinHewani?->id
            ],
            [
                'nama_makanan' => 'Ayam Serundeng',
                'deskripsi' => 'Ayam dengan taburan serundeng kelapa',
                'kategori_makanan_id' => $proteinHewani?->id
            ],
            [
                'nama_makanan' => 'Telur Balado',
                'deskripsi' => 'Telur dengan sambal balado pedas',
                'kategori_makanan_id' => $proteinHewani?->id
            ],
            [
                'nama_makanan' => 'Telur Dadar',
                'deskripsi' => 'Telur dadar sederhana dan bergizi',
                'kategori_makanan_id' => $proteinHewani?->id
            ],

            // Protein Nabati
            [
                'nama_makanan' => 'Tahu Goreng',
                'deskripsi' => 'Tahu goreng sebagai lauk pendamping',
                'kategori_makanan_id' => $proteinNabati?->id
            ],
            [
                'nama_makanan' => 'Tempe Goreng',
                'deskripsi' => 'Tempe goreng khas Indonesia',
                'kategori_makanan_id' => $proteinNabati?->id
            ],
            [
                'nama_makanan' => 'Tahu Saus Kecap',
                'deskripsi' => 'Tahu dengan saus kecap manis',
                'kategori_makanan_id' => $proteinNabati?->id
            ],

            // Sayuran
            [
                'nama_makanan' => 'Sayur Capcay',
                'deskripsi' => 'Tumisan sayuran beragam',
                'kategori_makanan_id' => $sayuran?->id
            ],
            [
                'nama_makanan' => 'Cah Wortel Jagung',
                'deskripsi' => 'Tumisan wortel dan jagung manis',
                'kategori_makanan_id' => $sayuran?->id
            ],
            [
                'nama_makanan' => 'Selada + Timun',
                'deskripsi' => 'Sayuran segar selada dan timun',
                'kategori_makanan_id' => $sayuran?->id
            ],
            [
                'nama_makanan' => 'Cah Wortel Buncis',
                'deskripsi' => 'Tumisan wortel dan buncis',
                'kategori_makanan_id' => $sayuran?->id
            ],
            [
                'nama_makanan' => 'Tumis Labu Siam',
                'deskripsi' => 'Tumisan labu siam yang segar',
                'kategori_makanan_id' => $sayuran?->id
            ],

            // Buah & Pelengkap
            [
                'nama_makanan' => 'Buah Pisang',
                'deskripsi' => 'Buah pisang kaya kalium',
                'kategori_makanan_id' => $buahPelengkap?->id
            ],
            [
                'nama_makanan' => 'Buah Semangka',
                'deskripsi' => 'Buah semangka segar dan manis',
                'kategori_makanan_id' => $buahPelengkap?->id
            ],
            [
                'nama_makanan' => 'Buah Anggur',
                'deskripsi' => 'Buah anggur kaya antioksidan',
                'kategori_makanan_id' => $buahPelengkap?->id
            ],
            [
                'nama_makanan' => 'Buah Melon',
                'deskripsi' => 'Buah melon segar dan menyegarkan',
                'kategori_makanan_id' => $buahPelengkap?->id
            ],
            [
                'nama_makanan' => 'Susu UHT',
                'deskripsi' => 'Susu UHT sebagai pelengkap gizi',
                'kategori_makanan_id' => $buahPelengkap?->id
            ],
        ];

        foreach ($makanans as $makanan) {
            Makanan::create($makanan);
        }
    }
}
