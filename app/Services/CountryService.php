<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\CountryRepository as Repository;

class CountryService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
