<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $roles = Role::all();
        foreach ($users as $user)
        {
            $role = $roles->where('id', $user->role_id)->first();
            $user->syncRoles($role);
        }
    }
}
