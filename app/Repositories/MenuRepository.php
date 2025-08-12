<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\MenuInterface;
use App\Models\User as Model;

class MenuRepository extends BaseRepository implements MenuInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
