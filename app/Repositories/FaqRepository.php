<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\FaqInterface;
use App\Models\Faq as Model;

class FaqRepository extends BaseRepository implements FaqInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
