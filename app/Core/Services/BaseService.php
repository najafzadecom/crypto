<?php

namespace App\Core\Services;

abstract class BaseService
{
    public function paginate()
    {
        return $this->repository->paginate();
    }

    public function getAll($sort = 'id', $direction = 'ASC'): iterable
    {
        return $this->repository->all($sort, $direction);
    }

    public function getById(int $id): ?object
    {
        return $this->repository->find($id);
    }

    public function create(array $data): object
    {
        // Check if this model has translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            return $this->createWithTranslations($data);
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?object
    {
        // Check if this model has translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            return $this->updateWithTranslations($id, $data);
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function restore(int $id)
    {
        return $this->repository->restore($id);
    }

    public function forceDelete(int $id)
    {
        return $this->repository->forceDelete($id);
    }

    /**
     * Create model with translations
     */
    protected function createWithTranslations(array $data): object
    {
        $translations = $data['translations'];
        unset($data['translations']);

        // Create the main model
        $model = $this->repository->create($data);

        // Create translations
        foreach ($translations as $translation) {
            if (!empty($translation['locale']) && !empty(array_filter($translation, function($value, $key) {
                return $key !== 'locale' && !empty($value);
            }, ARRAY_FILTER_USE_BOTH))) {
                $model->translations()->create($translation);
            }
        }

        return $model->load('translations');
    }

    /**
     * Update model with translations
     */
    protected function updateWithTranslations(int $id, array $data): ?object
    {
        $translations = $data['translations'];
        unset($data['translations']);

        // Update the main model
        $model = $this->repository->update($id, $data);

        if (!$model) {
            return null;
        }

        // Update translations
        foreach ($translations as $translation) {
            if (!empty($translation['locale'])) {
                // Check if translation exists
                $existingTranslation = $model->translations()
                    ->where('locale', $translation['locale'])
                    ->first();

                if ($existingTranslation) {
                    // Update existing translation
                    $existingTranslation->update($translation);
                } else {
                    // Create new translation if it has content
                    if (!empty(array_filter($translation, function($value, $key) {
                        return $key !== 'locale' && !empty($value);
                    }, ARRAY_FILTER_USE_BOTH))) {
                        $model->translations()->create($translation);
                    }
                }
            }
        }

        return $model->load('translations');
    }
}
