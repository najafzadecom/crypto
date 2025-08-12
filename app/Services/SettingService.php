<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\SettingRepository as Repository;

class SettingService extends BaseService
{
    public function __construct(protected Repository $repository) {}

    /**
     * Get setting value by key
     */
    public function getValue(string $key, $default = null)
    {
        $setting = $this->repository->getByKey($key);
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public function setValue(string $key, $value): bool
    {
        return $this->repository->updateByKey($key, $value);
    }

    /**
     * Get settings by group
     */
    public function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getByGroup($group);
    }

    /**
     * Get public settings
     */
    public function getPublicSettings(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getPublicSettings();
    }

    /**
     * Get all settings
     */
    public function getAll($sort = 'id', $direction = 'desc'): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getAll($sort, $direction);
    }

    /**
     * Get all settings grouped
     */
    public function getAllGrouped(): array
    {
        $settings = $this->repository->getAll();
        $grouped = [];

        foreach ($settings as $setting) {
            $grouped[$setting->group][] = $setting;
        }

        return $grouped;
    }
}