<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\SliderInterface;
use App\Models\Slider as Model;

class SliderRepository extends BaseRepository implements SliderInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
