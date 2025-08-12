<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function getModel(): Model;

    public function all(): iterable;

    public function paginate(): LengthAwarePaginator;

    public function find(int $id): object|null;

    public function create(array $data): object;

    public function update(int $id, array $data): object|null;

    public function delete(int $id): bool;
}
