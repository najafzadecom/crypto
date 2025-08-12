<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\PackageRepository as Repository;

class PackageService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
