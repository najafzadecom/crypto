<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\MenuItemInterface;
use App\Models\MenuItem as Model;

class MenuItemRepository extends BaseRepository implements MenuItemInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
