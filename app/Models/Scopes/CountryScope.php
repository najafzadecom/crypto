<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CountryScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $request = request();
        
        if ($request->has('name')) {
            $builder->whereHas('translations', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->has('code')) {
            $builder->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->has('status')) {
            $builder->where('status', $request->status);
        }
    }
}
