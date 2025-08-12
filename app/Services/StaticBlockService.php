<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\StaticBlockRepository as Repository;

class StaticBlockService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
