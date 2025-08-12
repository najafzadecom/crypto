<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\PermissionInterface;
use App\Models\Permission as Model;

class PermissionRepository extends BaseRepository implements PermissionInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
