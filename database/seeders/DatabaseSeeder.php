<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(DapurSehatSeeder::class);
        $this->call(SekolahSeeder::class);
        $this->call(KategoriMakananSeeder::class);
        $this->call(MakananSeeder::class);
        $this->call(JadwalMenuSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(ApplicationSetSeeder::class);
    }
}
