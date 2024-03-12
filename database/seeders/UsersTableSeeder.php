<?php

namespace Database\Seeders;

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
                'role_id' => ROLE_SUPER_ADMIN,
                'password' => bcrypt('hamkke@password')
            ],
            [
                'name' => 'Kemmieola',
                'email' => 'kemmieola@gmail.com',
                'role_id' => ROLE_SUPER_ADMIN,
                'password' => bcrypt('hamkke@password')
            ]
        ];

        foreach($users as $u) {
            $user = User::firstOrCreate(['email' => $u['email']], $u);
            $user->assignRole(ROLE_NAME_SUPER_ADMIN);
        }
    }
}
