<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::query()->create([
            'name' => 'Main Menu',
            'location' => 'header',
            'status' => true,
        ]);

        Menu::query()->create([
            'name' => 'Footer Menu',
            'location' => 'footer',
            'status' => true,
        ]);

        $this->command->info('Menus seeded successfully!');
    }
}
