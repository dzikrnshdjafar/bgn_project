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
        // Admin
        $user1 = User::find(1);
        $user1->assignRole('Admin');

        // Operator BGN
        $user2 = User::find(2);
        $user2->assignRole('Operator BGN');

        // Operator Sekolah (5 users)
        $user3 = User::find(3);
        $user3->assignRole('Operator Sekolah');

        $user4 = User::find(4);
        $user4->assignRole('Operator Sekolah');

        $user5 = User::find(5);
        $user5->assignRole('Operator Sekolah');

        $user6 = User::find(6);
        $user6->assignRole('Operator Sekolah');

        $user7 = User::find(7);
        $user7->assignRole('Operator Sekolah');

        // Operator SPPG (3 users)
        $user8 = User::find(8);
        $user8->assignRole('Operator SPPG');

        $user9 = User::find(9);
        $user9->assignRole('Operator SPPG');

        $user10 = User::find(10);
        $user10->assignRole('Operator SPPG');


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
