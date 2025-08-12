<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\FaqRepository as Repository;

class FaqService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
