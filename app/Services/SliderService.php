<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\SliderRepository as Repository;

class SliderService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
