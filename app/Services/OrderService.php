<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\OrderRepository as Repository;

class OrderService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
