<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample news with separate translations
        $newsData = [
            [
                'news' => [
                    'slug' => 'cryptocurrency-market-trends',
                    'is_featured' => true,
                    'status' => true,
                    'published_at' => now()->subDays(1),
                ],
                'translations' => [
                    'az' => [
                        'title' => 'Kriptovalyuta Bazarında Yeni Trendlər',
                        'content' => 'Kriptovalyuta bazarında son dövrlər böyük dəyişikliklər müşahidə olunur. Bitcoin və digər əsas kriptovalyutaların qiymətləri...',
                        'excerpt' => 'Kriptovalyuta bazarında müşahidə olunan yeni trendlər haqqında ətraflı məlumat.',
                    ],
                    'en' => [
                        'title' => 'New Trends in Cryptocurrency Market',
                        'content' => 'Recent developments in the cryptocurrency market show significant changes. Bitcoin and other major cryptocurrencies prices...',
                        'excerpt' => 'Detailed information about new trends observed in the cryptocurrency market.',
                    ],
                    'tr' => [
                        'title' => 'Kripto Para Piyasasında Yeni Trendler',
                        'content' => 'Kripto para piyasasında son dönemlerde büyük değişiklikler gözlemleniyor. Bitcoin ve diğer ana kripto paraların fiyatları...',
                        'excerpt' => 'Kripto para piyasasında gözlemlenen yeni trendler hakkında detaylı bilgi.',
                    ],
                ],
            ],
            [
                'news' => [
                    'slug' => 'blockchain-technology-future',
                    'is_featured' => false,
                    'status' => true,
                    'published_at' => now()->subDays(3),
                ],
                'translations' => [
                    'az' => [
                        'title' => 'Blockchain Texnologiyasının Gələcəyi',
                        'content' => 'Blockchain texnologiyası müxtəlif sahələrdə tətbiq olunmaqda davam edir. Maliyyə sektorundan başlayaraq...',
                        'excerpt' => 'Blockchain texnologiyasının müxtəlif sahələrdəki tətbiqi və gələcək perspektivləri.',
                    ],
                    'en' => [
                        'title' => 'Future of Blockchain Technology',
                        'content' => 'Blockchain technology continues to be applied in various sectors. Starting from the financial sector...',
                        'excerpt' => 'Application of blockchain technology in various sectors and future perspectives.',
                    ],
                    'tr' => [
                        'title' => 'Blockchain Teknolojisinin Geleceği',
                        'content' => 'Blockchain teknolojisi çeşitli sektörlerde uygulanmaya devam ediyor. Finans sektöründen başlayarak...',
                        'excerpt' => 'Blockchain teknolojisinin çeşitli sektörlerdeki uygulaması ve gelecek perspektifleri.',
                    ],
                ],
            ],
        ];

        foreach ($newsData as $data) {
            $news = News::create($data['news']);
            
            foreach ($data['translations'] as $locale => $translation) {
                $news->translations()->create([
                    'locale' => $locale,
                    'title' => $translation['title'],
                    'slug' => $translation['slug'] ?? \Str::slug($translation['title']),
                    'content' => $translation['content'],
                    'excerpt' => $translation['excerpt'],
                ]);
            }
        }

        // Create additional random news using factory
        News::factory(8)->create();
    }
}
