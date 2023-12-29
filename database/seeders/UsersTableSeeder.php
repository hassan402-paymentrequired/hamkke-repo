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
                'password' => Str::password(10, true, true, false)
            ],
            [
                'name' => 'Kemmieola',
                'email' => 'kemmieola@gmail.com',
                'role_id' => ROLE_SUPER_ADMIN,
                'password' => Str::password(10, true, true, false)
            ]
        ];

        foreach($users as $user) {
            $passwordString = $user['password'];
            $user['password'] = bcrypt($user['password']);
            $aUser = User::firstOrCreate(['email' => $user['email']], $user);
            if($aUser->wasRecentlyCreated){
                dump("Email: {$user['email']}, Password: {$passwordString}");
            }
        }
    }
}
