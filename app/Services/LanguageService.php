<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\LanguageRepository as Repository;

class LanguageService extends BaseService
{
    public function __construct(protected Repository $repository) {}

    /**
     * Get all active languages for forms
     */
    public function getActiveLanguages()
    {
        return $this->repository
            ->getModel()
            ->where('status', 1)
            ->orderBy('code')
            ->get(['id', 'code', 'name']);
    }

    /**
     * Get languages as key-value pairs (code => name)
     */
    public function getLanguagesForSelect()
    {
        return $this->getActiveLanguages()
            ->pluck('name', 'code')
            ->toArray();
    }

    /**
     * Get default locale
     */
    public function getDefaultLocale()
    {
        return config('app.locale', 'az');
    }

    /**
     * Get supported locales
     */
    public function getSupportedLocales(): array
    {
        return ['az', 'en', 'tr'];
    }
}
