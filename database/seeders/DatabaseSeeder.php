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
        $this->call(SekolahSeeder::class);
        $this->call(SppgSeeder::class);
        $this->call(SekolahSppgSeeder::class);
        $this->call(KategoriMenuSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(ApplicationSetSeeder::class);
    }
}
