<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Repositories\TransactionRepository as Repository;

class TransactionService extends BaseService
{
    public function __construct(protected Repository $repository) {}
}
