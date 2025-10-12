<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        Permission::create(['name' => 'CRUD']);
        Permission::create(['name' => 'EXPORT']);
        Permission::create(['name' => 'SEMI CRUD']);
    }
}
