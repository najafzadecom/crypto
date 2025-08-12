<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\CategoryInterface;
use App\Models\Category as Model;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
