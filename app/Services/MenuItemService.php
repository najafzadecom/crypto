<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\MenuItemRepository as Repository;

class MenuItemService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
