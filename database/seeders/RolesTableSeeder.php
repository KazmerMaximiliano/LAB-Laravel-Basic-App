<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissionsSuperAdmin = Permission::permissionAll();
        $permissionsAdmin = Permission::permissionExcept('roles-show roles-store roles-update roles-destroy');

        Role::create([
            'role' => 'superAdmin',
            'permission' => $permissionsSuperAdmin['permissions'],
            'description' => $permissionsSuperAdmin['descriptions']
        ]);

        Role::create([
            'role' => 'administrador',
            'permission' => $permissionsAdmin['permissions'],
            'description' => $permissionsAdmin['descriptions']
        ]);
    }
}
