<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'Azərbaycan dili',
                'code' => 'az',
                'locale' => 'az_AZ',
                'flag' => 'az.svg',
                'status' => true
            ],
            [
                'name' => 'English',
                'code' => 'en',
                'locale' => 'en_US',
                'flag' => 'en.svg',
                'status' => false
            ],
            [
                'name' => 'Русский',
                'code' => 'ru',
                'locale' => 'ru_RU',
                'flag' => 'ru.svg',
                'status' => false
            ],
            [
                'name' => 'Türkçe',
                'code' => 'tr',
                'locale' => 'tr_TR',
                'flag' => 'tr.svg',
                'status' => false
            ],
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['code' => $language['code']], $language);
        }

        $this->command->info('Languages seeded successfully!');
    }
}
