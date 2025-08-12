<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\OrderInterface;
use App\Models\Order as Model;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
