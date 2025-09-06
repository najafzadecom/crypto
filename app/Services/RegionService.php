<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\RegionRepository as Repository;

class RegionService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
