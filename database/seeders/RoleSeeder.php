<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->create([
            'name' => 'Super Admin',
            'color' => 'bg-success',
            'guard_name' => 'web',
            'status' => true,
            'protected' => true,
        ]);

        Role::query()->create([
            'name' => 'Admin',
            'color' => 'bg-primary',
            'guard_name' => 'web',
            'status' => true,
            'protected' => true,
        ]);

        Role::query()->create([
            'name' => 'Customer',
            'color' => 'bg-warning',
            'guard_name' => 'web',
            'status' => true,
            'protected' => true,
        ]);

        $this->command->info('Roles seeded successfully!');
    }
}
