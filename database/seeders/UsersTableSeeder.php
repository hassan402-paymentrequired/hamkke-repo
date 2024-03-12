<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Str;

use function Laravel\Prompts\password;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Victoria Etim',
                'email' => 'vkeylicious@gmail.com',
                'password' => bcrypt('hamkke@password')
            ],
            [
                'name' => 'Kemmieola',
                'email' => 'kemmieola@gmail.com',
                'password' => bcrypt('hamkke@password')
            ]
        ];
        $role = Role::find(ROLE_SUPER_ADMIN);
        foreach($users as $u) {
            $user = User::firstOrCreate(['email' => $u['email']], $u);
            $user->syncRoles($role);
        }
    }
}
