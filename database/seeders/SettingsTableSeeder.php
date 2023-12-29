<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(GeneralSetting::seedData() as $setting)
        {
            GeneralSetting::firstOrCreate(['id' => $setting['id']],$setting);
        }
    }
}
