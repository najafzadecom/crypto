<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\CategoryRepository as Repository;

class CategoryService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
