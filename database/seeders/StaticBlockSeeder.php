<?php

namespace Database\Seeders;

use App\Models\StaticBlock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaticBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaticBlock::factory(10)->create();

        $this->command->info('Static blocks seeded successfully!');
    }
}
