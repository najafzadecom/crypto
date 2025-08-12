<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\PermissionRepository as Repository;

class PermissionService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
