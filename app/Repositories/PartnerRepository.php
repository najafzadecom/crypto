<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\PartnerInterface;
use App\Models\Partner as Model;

class PartnerRepository extends BaseRepository implements PartnerInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
