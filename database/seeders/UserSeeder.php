<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class   UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->create([
            'username' => 'admin',
            'name' => 'John Doe',
            'email' => 'admin@orig.com',
            'password' => Hash::make('12345678')
        ]);

        $user->syncRoles('Super Admin');
    }
}
