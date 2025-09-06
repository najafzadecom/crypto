<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryTranslation;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'code' => 'AZ',
                'phone_code' => '994',
                'flag' => 'az.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Azərbaycan'],
                ],
            ],
            [
                'code' => 'TR',
                'phone_code' => '90',
                'flag' => 'tr.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Türkiyə'],
                ],
            ],
            [
                'code' => 'US',
                'phone_code' => '1',
                'flag' => 'us.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Amerika Birləşmiş Ştatları'],
                ],
            ],
            [
                'code' => 'GB',
                'phone_code' => '44',
                'flag' => 'gb.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Birləşmiş Krallıq'],
                ],
            ],
            [
                'code' => 'DE',
                'phone_code' => '49',
                'flag' => 'de.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Almaniya'],
                ],
            ],
            [
                'code' => 'FR',
                'phone_code' => '33',
                'flag' => 'fr.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Fransa'],
                ],
            ],
            [
                'code' => 'IT',
                'phone_code' => '39',
                'flag' => 'it.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'İtaliya'],
                ],
            ],
            [
                'code' => 'ES',
                'phone_code' => '34',
                'flag' => 'es.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'İspaniya'],
                ],
            ],
            [
                'code' => 'RU',
                'phone_code' => '7',
                'flag' => 'ru.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Rusiya'],
                ],
            ],
            [
                'code' => 'CN',
                'phone_code' => '86',
                'flag' => 'cn.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Çin'],
                ],
            ],
            [
                'code' => 'JP',
                'phone_code' => '81',
                'flag' => 'jp.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Yaponiya'],
                ],
            ],
            [
                'code' => 'IN',
                'phone_code' => '91',
                'flag' => 'in.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Hindistan'],
                ],
            ],
            [
                'code' => 'BR',
                'phone_code' => '55',
                'flag' => 'br.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Braziliya'],
                ],
            ],
            [
                'code' => 'CA',
                'phone_code' => '1',
                'flag' => 'ca.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Kanada'],
                ],
            ],
            [
                'code' => 'AU',
                'phone_code' => '61',
                'flag' => 'au.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Avstraliya'],
                ],
            ],
            [
                'code' => 'ZA',
                'phone_code' => '27',
                'flag' => 'za.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Cənubi Afrika'],
                ],
            ],
            [
                'code' => 'MX',
                'phone_code' => '52',
                'flag' => 'mx.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Meksika'],
                ],
            ],
            [
                'code' => 'ID',
                'phone_code' => '62',
                'flag' => 'id.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'İndoneziya'],
                ],
            ],
            [
                'code' => 'KR',
                'phone_code' => '82',
                'flag' => 'kr.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Cənubi Koreya'],
                ],
            ],
            [
                'code' => 'SA',
                'phone_code' => '966',
                'flag' => 'sa.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Səudiyyə Ərəbistanı'],
                ],
            ],
            [
                'code' => 'AE',
                'phone_code' => '971',
                'flag' => 'ae.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Birləşmiş Ərəb Əmirlikləri'],
                ],
            ],
            [
                'code' => 'EG',
                'phone_code' => '20',
                'flag' => 'eg.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Misir'],
                ],
            ],
            [
                'code' => 'AR',
                'phone_code' => '54',
                'flag' => 'ar.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Argentina'],
                ],
            ],
            [
                'code' => 'SE',
                'phone_code' => '46',
                'flag' => 'se.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'İsveç'],
                ],
            ],
            [
                'code' => 'NO',
                'phone_code' => '47',
                'flag' => 'no.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Norveç'],
                ],
            ],
            [
                'code' => 'FI',
                'phone_code' => '358',
                'flag' => 'fi.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Finlandiya'],
                ],
            ],
            [
                'code' => 'DK',
                'phone_code' => '45',
                'flag' => 'dk.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Danimarka'],
                ],
            ],
            [
                'code' => 'NL',
                'phone_code' => '31',
                'flag' => 'nl.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Niderland'],
                ],
            ],
            [
                'code' => 'BE',
                'phone_code' => '32',
                'flag' => 'be.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Belçika'],
                ],
            ],
            [
                'code' => 'CH',
                'phone_code' => '41',
                'flag' => 'ch.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'İsveçrə'],
                ],
            ],
            [
                'code' => 'AT',
                'phone_code' => '43',
                'flag' => 'at.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Avstriya'],
                ],
            ],
            [
                'code' => 'GR',
                'phone_code' => '30',
                'flag' => 'gr.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Yunanıstan'],
                ],
            ],
            [
                'code' => 'PT',
                'phone_code' => '351',
                'flag' => 'pt.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Portuqaliya'],
                ],
            ],
            [
                'code' => 'IE',
                'phone_code' => '353',
                'flag' => 'ie.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'İrlandiya'],
                ],
            ],
            [
                'code' => 'PL',
                'phone_code' => '48',
                'flag' => 'pl.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Polşa'],
                ],
            ],
            [
                'code' => 'UA',
                'phone_code' => '380',
                'flag' => 'ua.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Ukrayna'],
                ],
            ],
            [
                'code' => 'GE',
                'phone_code' => '995',
                'flag' => 'ge.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Gürcüstan'],
                ],
            ],
            [
                'code' => 'AM',
                'phone_code' => '374',
                'flag' => 'am.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Ermənistan'],
                ],
            ],
            [
                'code' => 'KZ',
                'phone_code' => '7',
                'flag' => 'kz.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Qazaxıstan'],
                ],
            ],
            [
                'code' => 'UZ',
                'phone_code' => '998',
                'flag' => 'uz.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Özbəkistan'],
                ],
            ],
            [
                'code' => 'TM',
                'phone_code' => '993',
                'flag' => 'tm.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Türkmənistan'],
                ],
            ],
            [
                'code' => 'KG',
                'phone_code' => '996',
                'flag' => 'kg.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Qırğızıstan'],
                ],
            ],
            [
                'code' => 'TJ',
                'phone_code' => '992',
                'flag' => 'tj.png',
                'status' => true,
                'translations' => [
                    'az' => ['name' => 'Tacikistan'],
                ],
            ],
        ];

        foreach ($countries as $countryData) {
            $translations = $countryData['translations'];
            unset($countryData['translations']);

            $country = Country::firstOrCreate(
                ['code' => $countryData['code']],
                $countryData
            );

            foreach ($translations as $locale => $translationData) {
                CountryTranslation::updateOrCreate(
                    [
                        'country_id' => $country->id,
                        'locale' => $locale
                    ],
                    $translationData
                );
            }
        }

        $this->command->info('Country seeder has been run successfully.');
    }
}