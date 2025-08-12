<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Interfaces\TestimonialInterface;
use App\Models\Testimonial as Model;

class TestimonialRepository extends BaseRepository implements TestimonialInterface
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
