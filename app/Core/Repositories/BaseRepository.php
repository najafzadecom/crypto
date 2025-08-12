<?php

namespace App\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Core\Contracts\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function getModel(): Model
    {
        return $this->model;
    }


    public function all($sort = 'id', $direction = 'ASC'): iterable
    {
        $query = $this->model->query();
        
        // Auto-load translations if the model has translations relationship
        if (method_exists($this->model, 'translations')) {
            $query->with('translations');
        }
        
        return $query->orderBy($sort, $direction)->get();
    }

    public function paginate(
    ): LengthAwarePaginator
    {
        $perPage = (int)request('limit', config('pagination.per_page'));
        $perPage = in_array($perPage, config('pagination.per_pages')) ? $perPage : config('pagination.per_page');

        $query = $this->model->query();
        
        // Auto-load translations if the model has translations relationship
        if (method_exists($this->model, 'translations')) {
            $query->with('translations');
        }

        return $query->paginate($perPage)->appends(request()->query());
    }

    public function find(int $id): ?object
    {
        $query = $this->model->query();
        
        // Auto-load translations if the model has translations relationship
        if (method_exists($this->model, 'translations')) {
            $query->with('translations');
        }
        
        return $query->find($id);
    }

    public function create(array $data): object
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?object
    {
        $item = $this->find($id);
        if (!$item) return null;
        $item->update($data);

        return $item;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }

    public function restore(int $id): bool
    {
        return $this->model->query()->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->model->forceDelete($id);
    }
}
