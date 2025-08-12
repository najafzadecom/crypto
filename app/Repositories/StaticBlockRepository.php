<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\StaticBlockInterface;
use App\Models\StaticBlock as Model;

class StaticBlockRepository extends BaseRepository implements StaticBlockInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
