<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => ROLE_SUPER_ADMIN,
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'hierarchy' => 100
            ],
            [
                'id' => ROLE_WRITER,
                'name' => 'writer',
                'display_name' => 'Writer',
                'hierarchy' => 80
            ]
        ];
        foreach($roles as $role)
        {
            Role::firstOrCreate(
                ['id' => $role['id']],
                $role
            );
        }
    }
}
