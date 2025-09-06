<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            CurrencySeeder::class,
            CountrySeeder::class,
            RegionSeeder::class,
        ]);


        $this->command->info('All seeders have been run successfully.');
    }
}
