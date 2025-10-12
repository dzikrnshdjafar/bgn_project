<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Buat roles
        $adminRole = Role::create(['name' => 'Admin']);
        $OpBGNRole = Role::create(['name' => 'Operator BGN']);
        $OpSekolahRole = Role::create(['name' => 'Operator Sekolah']);
        $OpSPPGRole = Role::create(['name' => 'Operator SPPG']);

        // Sinkronisasi User & Role
        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);
        $user4 = User::find(4);

        $user1->assignRole('Admin');
        $user2->assignRole('Operator BGN');
        $user3->assignRole('Operator Sekolah');
        $user4->assignRole('Operator SPPG');


        // Deklarasi permissions to roles
        $crudPermission = Permission::where('name', 'CRUD')->first();
        $exportPermission = Permission::where('name', 'EXPORT')->first();
        $semiCrudPermission = Permission::where('name', 'SEMI CRUD')->first();

        if ($crudPermission) {
            $adminRole->givePermissionTo($crudPermission);
        }

        if ($exportPermission) {
            $OpBGNRole->givePermissionTo($exportPermission);
        }

        if ($semiCrudPermission) {
            $OpSekolahRole->givePermissionTo($semiCrudPermission);
        }

        if ($semiCrudPermission) {
            $OpSPPGRole->givePermissionTo($semiCrudPermission);
        }
    }
}
