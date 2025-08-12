<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\NewsInterface;
use App\Models\News as Model;

class NewsRepository extends BaseRepository implements NewsInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
