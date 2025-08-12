<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RoleScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $request = request();


        // Individual field filters
        if ($request->filled('name')) {
            $builder->where('name', 'like', '%' . $request->get('name') . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            $builder->where('status', (bool)$request->get('status'));
        }

        // Date filters
        if ($request->filled('created_from')) {
            $builder->where('created_at', '>=', $request->get('created_from'));
        }

        if ($request->filled('created_to')) {
            $builder->where('created_at', '<=', $request->get('created_to'));
        }

        if ($request->filled('updated_from')) {
            $builder->where('updated_at', '>=', $request->get('updated_from'));
        }

        if ($request->filled('updated_to')) {
            $builder->where('updated_at', '<=', $request->get('updated_to'));
        }
    }
}
