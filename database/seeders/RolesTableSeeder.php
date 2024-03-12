<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles with their attributes
        $roles = Role::seedData();

        // Create or update roles in the database
        foreach ($roles as $role) {
            $currentRole = Role::updateOrCreate(['id' => $role['id']], $role);
            if ($currentRole->id === ROLE_SUPER_ADMIN) {
                $superAdminRole = $currentRole;
            }
        }
        $allPermissions = Permission::all();
        // Insert role permissions into the database, ignoring duplicates
        $superAdminRole->syncPermissions($allPermissions);
    }

}
