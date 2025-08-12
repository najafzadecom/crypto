<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\TestimonialRepository as Repository;

class TestimonialService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
