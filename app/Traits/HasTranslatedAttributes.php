<?php

namespace App\Traits;

trait HasTranslatedAttributes
{
    /**
     * Get translated attribute value
     * First tries current locale, then default locale, then first available translation
     *
     * @param string $attribute
     * @param string|null $locale
     * @return string|null
     */
    public function getTranslatedAttribute(string $attribute, ?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();
        
        // Try current/specified locale first
        $translation = $this->translations->where('locale', $locale)->first();
        if ($translation && isset($translation->$attribute) && !empty($translation->$attribute)) {
            return $translation->$attribute;
        }

        // Try default locale
        $defaultLocale = config('app.locale', 'az');
        if ($locale !== $defaultLocale) {
            $translation = $this->translations->where('locale', $defaultLocale)->first();
            if ($translation && isset($translation->$attribute) && !empty($translation->$attribute)) {
                return $translation->$attribute;
            }
        }

        // Fallback to first available translation
        $firstTranslation = $this->translations->first();
        if ($firstTranslation && isset($firstTranslation->$attribute)) {
            return $firstTranslation->$attribute;
        }

        return null;
    }

    /**
     * Get translated name (most common use case)
     *
     * @param string|null $locale
     * @return string
     */
    public function getTranslatedName(?string $locale = null): string
    {
        return $this->getTranslatedAttribute('name', $locale) ?? 'N/A';
    }

    /**
     * Get translated title (for models that use title instead of name)
     *
     * @param string|null $locale
     * @return string
     */
    public function getTranslatedTitle(?string $locale = null): string
    {
        return $this->getTranslatedAttribute('title', $locale) ?? 'N/A';
    }

    /**
     * Get translated description
     *
     * @param string|null $locale
     * @return string|null
     */
    public function getTranslatedDescription(?string $locale = null): ?string
    {
        return $this->getTranslatedAttribute('description', $locale);
    }

    /**
     * Get translated content
     *
     * @param string|null $locale
     * @return string|null
     */
    public function getTranslatedContent(?string $locale = null): ?string
    {
        return $this->getTranslatedAttribute('content', $locale);
    }

    /**
     * Get translated excerpt
     *
     * @param string|null $locale
     * @return string|null
     */
    public function getTranslatedExcerpt(?string $locale = null): ?string
    {
        return $this->getTranslatedAttribute('excerpt', $locale);
    }

    /**
     * Get translated slug
     *
     * @param string|null $locale
     * @return string|null
     */
    public function getTranslatedSlug(?string $locale = null): ?string
    {
        return $this->getTranslatedAttribute('slug', $locale);
    }

    /**
     * Magic getter for translated attributes
     * Usage: $model->translated_name, $model->translated_title, etc.
     */
    public function __get($key)
    {
        if (str_starts_with($key, 'translated_')) {
            $attribute = str_replace('translated_', '', $key);
            return $this->getTranslatedAttribute($attribute);
        }

        return parent::__get($key);
    }
}
