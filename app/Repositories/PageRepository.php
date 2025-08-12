<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\PageInterface;
use App\Models\Page as Model;

class PageRepository extends BaseRepository implements PageInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
