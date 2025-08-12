<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => fake()->imageUrl(800, 600, 'news', true),
            'slug' => fake()->unique()->slug(),
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'status' => fake()->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Configure the factory with translations.
     */
    public function configure()
    {
        return $this->afterCreating(function ($news) {
            $locales = ['az', 'en', 'tr'];
            
            foreach ($locales as $locale) {
                $news->translations()->create([
                    'locale' => $locale,
                    'title' => fake($this->getLocaleForFaker($locale))->sentence(6),
                    'content' => fake($this->getLocaleForFaker($locale))->paragraphs(5, true),
                    'excerpt' => fake($this->getLocaleForFaker($locale))->text(200),
                ]);
            }
        });
    }

    /**
     * Get faker locale code.
     */
    private function getLocaleForFaker(string $locale): string
    {
        return match ($locale) {
            'az' => 'az_AZ',
            'en' => 'en_US',
            'tr' => 'tr_TR',
            default => 'en_US',
        };
    }
}
