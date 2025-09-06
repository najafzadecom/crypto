<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\PartnerRepository as Repository;

class PartnerService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
