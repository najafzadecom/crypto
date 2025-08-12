<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\PackageInterface;
use App\Models\Package as Model;

class PackageRepository extends BaseRepository implements PackageInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
