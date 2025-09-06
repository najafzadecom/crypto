<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Region;
use App\Models\RegionTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Azerbaijan regions
        $azCountry = Country::where('code', 'AZ')->first();
        if ($azCountry) {
            $regions = [
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Bakı'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Gəncə'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Sumqayıt'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Şəki'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Lənkəran'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Quba'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Naxçıvan'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Mingəçevir'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Şirvan'],
                    ]
                ],
                [
                    'country_id' => $azCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Şuşa'],
                    ]
                ],
            ];

            foreach ($regions as $regionData) {
                $translations = $regionData['translations'];
                unset($regionData['translations']);

                $region = Region::firstOrCreate(
                    [
                        'country_id' => $regionData['country_id'],
                        'status' => $regionData['status']
                    ],
                    $regionData
                );

                foreach ($translations as $locale => $translationData) {
                    RegionTranslation::updateOrCreate(
                        [
                            'region_id' => $region->id,
                            'locale' => $locale
                        ],
                        $translationData
                    );
                }
            }
        }

        // Turkey regions
        $trCountry = Country::where('code', 'TR')->first();
        if ($trCountry) {
            $regions = [
                [
                    'country_id' => $trCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'İstanbul'],
                    ]
                ],
                [
                    'country_id' => $trCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Ankara'],
                    ]
                ],
                [
                    'country_id' => $trCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'İzmir'],
                    ]
                ],
                [
                    'country_id' => $trCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Antalya'],
                    ]
                ],
                [
                    'country_id' => $trCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Bursa'],
                    ]
                ],
            ];

            foreach ($regions as $regionData) {
                $translations = $regionData['translations'];
                unset($regionData['translations']);

                $region = Region::firstOrCreate(
                    [
                        'country_id' => $regionData['country_id'],
                        'status' => $regionData['status']
                    ],
                    $regionData
                );

                foreach ($translations as $locale => $translationData) {
                    RegionTranslation::updateOrCreate(
                        [
                            'region_id' => $region->id,
                            'locale' => $locale
                        ],
                        $translationData
                    );
                }
            }
        }

        // United States regions
        $usCountry = Country::where('code', 'US')->first();
        if ($usCountry) {
            $regions = [
                [
                    'country_id' => $usCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Nyu York'],
                    ]
                ],
                [
                    'country_id' => $usCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Los Anceles'],
                    ]
                ],
                [
                    'country_id' => $usCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Çikaqo'],
                    ]
                ],
                [
                    'country_id' => $usCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Vaşinqton'],
                    ]
                ],
                [
                    'country_id' => $usCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Mayami'],
                    ]
                ],
            ];

            foreach ($regions as $regionData) {
                $translations = $regionData['translations'];
                unset($regionData['translations']);

                $region = Region::firstOrCreate(
                    [
                        'country_id' => $regionData['country_id'],
                        'status' => $regionData['status']
                    ],
                    $regionData
                );

                foreach ($translations as $locale => $translationData) {
                    RegionTranslation::updateOrCreate(
                        [
                            'region_id' => $region->id,
                            'locale' => $locale
                        ],
                        $translationData
                    );
                }
            }
        }

        // United Kingdom regions
        $gbCountry = Country::where('code', 'GB')->first();
        if ($gbCountry) {
            $regions = [
                [
                    'country_id' => $gbCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'London'],
                    ]
                ],
                [
                    'country_id' => $gbCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Mançester'],
                    ]
                ],
                [
                    'country_id' => $gbCountry->id,
                    'status' => true,
                    'translations' => [
                        'az' => ['name' => 'Liverpul'],
                    ]
                ],
            ];

            foreach ($regions as $regionData) {
                $translations = $regionData['translations'];
                unset($regionData['translations']);

                $region = Region::firstOrCreate(
                    [
                        'country_id' => $regionData['country_id'],
                        'status' => $regionData['status']
                    ],
                    $regionData
                );

                foreach ($translations as $locale => $translationData) {
                    RegionTranslation::updateOrCreate(
                        [
                            'region_id' => $region->id,
                            'locale' => $locale
                        ],
                        $translationData
                    );
                }
            }
        }

        $this->command->info('Region seeder has been run successfully.');
    }
}