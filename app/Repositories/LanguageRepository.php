<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\LanguageInterface;
use App\Models\Language as Model;

class LanguageRepository extends BaseRepository implements LanguageInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
