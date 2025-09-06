<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\RegionInterface;
use App\Models\Region as Model;

class RegionRepository extends BaseRepository implements RegionInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
