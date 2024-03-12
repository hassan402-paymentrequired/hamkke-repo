<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            SettingsTableSeeder::class,
            PostTypesTableSeeder::class,
            PostCategoriesTableSeeder::class
        ]);
    }
}
