<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\CurrencyRepository as Repository;

class CurrencyService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
