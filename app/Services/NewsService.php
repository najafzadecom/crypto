<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\NewsRepository as Repository;

class NewsService extends BaseService
{
    public function __construct(protected Repository $repository) {}

    public function create(array $data): object
    {
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        // Check if this model has translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            $news = $this->createWithTranslations($data);
        } else {
            $news = $this->repository->create($data);
        }

        // Assign categories
        if (!empty($categoryIds)) {
            $news->categories()->sync($categoryIds);
        }

        return $news;
    }

    public function update(int $id, array $data): ?object
    {
        $categoryIds = $data['category_ids'] ?? [];
        unset($data['category_ids']);

        // Check if this model has translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            $news = $this->updateWithTranslations($id, $data);
        } else {
            $news = $this->repository->update($id, $data);
        }

        if (!$news) {
            return null;
        }

        // Update categories
        $news->categories()->sync($categoryIds);

        return $news;
    }
}
