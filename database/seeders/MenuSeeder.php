<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get kategori IDs
        $karbohidrat = KategoriMenu::where('nama_kategori', 'Karbohidrat')->first();
        $proteinHewani = KategoriMenu::where('nama_kategori', 'Protein Hewani')->first();
        $sayur = KategoriMenu::where('nama_kategori', 'Sayur')->first();
        $proteinNabati = KategoriMenu::where('nama_kategori', 'Protein Nabati')->first();
        $buahPelengkap = KategoriMenu::where('nama_kategori', 'Buah/Pelengkap')->first();

        $menus = [
            // Karbohidrat
            [
                'kategori_menu_id' => $karbohidrat->id,
                'nama_menu' => 'Nasi Putih',
                'deskripsi' => 'Nasi putih pulen',
            ],
            [
                'kategori_menu_id' => $karbohidrat->id,
                'nama_menu' => 'Nasi Merah',
                'deskripsi' => 'Nasi merah sehat dan bergizi',
            ],
            [
                'kategori_menu_id' => $karbohidrat->id,
                'nama_menu' => 'Mie Goreng',
                'deskripsi' => 'Mie goreng dengan sayuran',
            ],
            [
                'kategori_menu_id' => $karbohidrat->id,
                'nama_menu' => 'Kentang Rebus',
                'deskripsi' => 'Kentang rebus sebagai pengganti nasi',
            ],

            // Protein Hewani
            [
                'kategori_menu_id' => $proteinHewani->id,
                'nama_menu' => 'Ayam Goreng',
                'deskripsi' => 'Ayam goreng bumbu kuning',
            ],
            [
                'kategori_menu_id' => $proteinHewani->id,
                'nama_menu' => 'Telur Dadar',
                'deskripsi' => 'Telur dadar praktis dan bergizi',
            ],
            [
                'kategori_menu_id' => $proteinHewani->id,
                'nama_menu' => 'Ikan Goreng',
                'deskripsi' => 'Ikan goreng segar',
            ],
            [
                'kategori_menu_id' => $proteinHewani->id,
                'nama_menu' => 'Rendang Daging',
                'deskripsi' => 'Rendang daging sapi empuk',
            ],
            [
                'kategori_menu_id' => $proteinHewani->id,
                'nama_menu' => 'Sate Ayam',
                'deskripsi' => 'Sate ayam dengan bumbu kacang',
            ],

            // Sayur
            [
                'kategori_menu_id' => $sayur->id,
                'nama_menu' => 'Sayur Asem',
                'deskripsi' => 'Sayur asem segar dengan berbagai sayuran',
            ],
            [
                'kategori_menu_id' => $sayur->id,
                'nama_menu' => 'Capcay',
                'deskripsi' => 'Tumis sayuran beragam',
            ],
            [
                'kategori_menu_id' => $sayur->id,
                'nama_menu' => 'Kangkung Tumis',
                'deskripsi' => 'Kangkung tumis belacan',
            ],
            [
                'kategori_menu_id' => $sayur->id,
                'nama_menu' => 'Sayur Lodeh',
                'deskripsi' => 'Sayur lodeh santan',
            ],
            [
                'kategori_menu_id' => $sayur->id,
                'nama_menu' => 'Sayur Bayam',
                'deskripsi' => 'Sayur bayam bening',
            ],

            // Protein Nabati
            [
                'kategori_menu_id' => $proteinNabati->id,
                'nama_menu' => 'Tahu Goreng',
                'deskripsi' => 'Tahu goreng renyah',
            ],
            [
                'kategori_menu_id' => $proteinNabati->id,
                'nama_menu' => 'Tempe Goreng',
                'deskripsi' => 'Tempe goreng crispy',
            ],
            [
                'kategori_menu_id' => $proteinNabati->id,
                'nama_menu' => 'Tahu Bacem',
                'deskripsi' => 'Tahu bacem manis gurih',
            ],
            [
                'kategori_menu_id' => $proteinNabati->id,
                'nama_menu' => 'Tempe Mendoan',
                'deskripsi' => 'Tempe mendoan khas Banyumas',
            ],
            [
                'kategori_menu_id' => $proteinNabati->id,
                'nama_menu' => 'Perkedel Tahu',
                'deskripsi' => 'Perkedel tahu isi sayuran',
            ],

            // Buah/Pelengkap
            [
                'kategori_menu_id' => $buahPelengkap->id,
                'nama_menu' => 'Pisang',
                'deskripsi' => 'Pisang segar',
            ],
            [
                'kategori_menu_id' => $buahPelengkap->id,
                'nama_menu' => 'Jeruk',
                'deskripsi' => 'Jeruk manis',
            ],
            [
                'kategori_menu_id' => $buahPelengkap->id,
                'nama_menu' => 'Apel',
                'deskripsi' => 'Apel merah segar',
            ],
            [
                'kategori_menu_id' => $buahPelengkap->id,
                'nama_menu' => 'Kerupuk',
                'deskripsi' => 'Kerupuk udang renyah',
            ],
            [
                'kategori_menu_id' => $buahPelengkap->id,
                'nama_menu' => 'Sambal',
                'deskripsi' => 'Sambal terasi pedas',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
