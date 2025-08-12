<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\PageRepository as Repository;

class PageService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
