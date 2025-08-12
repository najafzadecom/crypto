<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\NewsRepository as Repository;

class NewsService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
