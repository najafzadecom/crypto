<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\RoleInterface;
use App\Models\Role as Model;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
