<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sistem controllerlərində istifadə olunan bütün permissionlar
        $permissions = [
            // User permissions
            'users-index',
            'users-create',
            'users-edit',
            'users-delete',
            'users-show',

            // Role permissions
            'roles-index',
            'roles-create',
            'roles-edit',
            'roles-delete',
            'roles-show',

            // Permission permissions
            'permissions-index',
            'permissions-create',
            'permissions-edit',
            'permissions-delete',
            'permissions-show',

            // Language permissions
            'languages-index',
            'languages-create',
            'languages-edit',
            'languages-delete',
            'languages-show',

            // Category permissions
            'categories-index',
            'categories-create',
            'categories-edit',
            'categories-delete',
            'categories-show',

            // FAQ permissions
            'faqs-index',
            'faqs-create',
            'faqs-edit',
            'faqs-delete',
            'faqs-show',

            // News permissions
            'news-index',
            'news-create',
            'news-edit',
            'news-delete',
            'news-show',

            // Page permissions
            'pages-index',
            'pages-create',
            'pages-edit',
            'pages-delete',
            'pages-show',

            // Menu permissions
            'menus-index',
            'menus-create',
            'menus-edit',
            'menus-delete',
            'menus-show',

            // Menu Item permissions
            'menu-items-index',
            'menu-items-create',
            'menu-items-edit',
            'menu-items-delete',
            'menu-items-show',

            // Slider permissions
            'sliders-index',
            'sliders-create',
            'sliders-edit',
            'sliders-delete',
            'sliders-show',

            // Static Block permissions
            'static-blocks-index',
            'static-blocks-create',
            'static-blocks-edit',
            'static-blocks-delete',
            'static-blocks-show',

            // Testimonial permissions
            'testimonials-index',
            'testimonials-create',
            'testimonials-edit',
            'testimonials-delete',
            'testimonials-show',

            // Package permissions
            'packages-index',
            'packages-create',
            'packages-edit',
            'packages-delete',
            'packages-show',

            // Order permissions
            'orders-index',
            'orders-create',
            'orders-edit',
            'orders-delete',
            'orders-show',

            // Transaction permissions
            'transactions-index',
            'transactions-create',
            'transactions-edit',
            'transactions-delete',
            'transactions-show',

            // Settings permissions (yalnız index və edit)
            'settings-index',
            'settings-edit',

            // Activity Log permissions (yalnız index və show)
            'activity-logs-index',
            'activity-logs-show',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $this->command->info('Permissionlar uğurla yaradıldı!');
    }
}
