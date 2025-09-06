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
        $permissions = [
            // User permissions
            'user-index',
            'user-create',
            'user-edit',
            'user-delete',
            'user-show',

            // Role permissions
            'role-index',
            'role-create',
            'role-edit',
            'role-delete',
            'role-show',

            // Permission permissions
            'permission-index',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'permission-show',

            // Language permissions
            'language-index',
            'language-create',
            'language-edit',
            'language-delete',
            'language-show',

            // Category permissions
            'category-index',
            'category-create',
            'category-edit',
            'category-delete',
            'category-show',

            // FAQ permissions
            'faq-index',
            'faq-create',
            'faq-edit',
            'faq-delete',
            'faq-show',

            // News permissions
            'news-index',
            'news-create',
            'news-edit',
            'news-delete',
            'news-show',

            // Page permissions
            'page-index',
            'page-create',
            'page-edit',
            'page-delete',
            'page-show',

            // Menu permissions
            'menu-index',
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-show',

            // Menu Item permissions
            'menu-item-index',
            'menu-item-create',
            'menu-item-edit',
            'menu-item-delete',
            'menu-item-show',

            // Slider permissions
            'slider-index',
            'slider-create',
            'slider-edit',
            'slider-delete',
            'slider-show',

            // Static Block permissions
            'static-block-index',
            'static-block-create',
            'static-block-edit',
            'static-block-delete',
            'static-block-show',

            // Testimonial permissions
            'testimonial-index',
            'testimonial-create',
            'testimonial-edit',
            'testimonial-delete',
            'testimonial-show',

            // Package permissions
            'package-index',
            'package-create',
            'package-edit',
            'package-delete',
            'package-show',

            // Order permissions
            'order-index',
            'order-edit',
            'order-delete',
            'order-show',

            // Transaction permissions
            'transaction-index',
            'transaction-show',

            // Settings permissions (only index and edit)
            'setting-index',
            'setting-edit',

            // Activity Log permissions (only index and show)
            'activity-log-index',
            'activity-log-show',

            // Partner permissions
            'partner-index',
            'partner-create',
            'partner-edit',
            'partner-show',
            'partner-delete',

            // Currency permissions
            'currency-index',
            'currency-create',
            'currency-edit',
            'currency-show',
            'currency-delete',
            
            // Country permissions
            'country-index',
            'country-create',
            'country-edit',
            'country-show',
            'country-delete',
            
            // Region permissions
            'region-index',
            'region-create',
            'region-edit',
            'region-show',
            'region-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $this->command->info('All permissions seeded successfully.');
    }
}
