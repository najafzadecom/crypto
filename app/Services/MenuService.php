<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\MenuRepository as Repository;

class MenuService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
