<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\CountryInterface;
use App\Models\Country as Model;

class CountryRepository extends BaseRepository implements CountryInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
