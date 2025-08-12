<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\TransactionInterface;
use App\Models\Transaction as Model;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
