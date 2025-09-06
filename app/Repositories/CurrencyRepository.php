<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\CurrencyInterface;
use App\Models\Currency as Model;

class CurrencyRepository extends BaseRepository implements CurrencyInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
