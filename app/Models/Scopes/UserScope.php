<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $request = request();

        // Global search across multiple fields
       if ($request->filled('search')) {
           $search = $request->get('search');
           $builder->where(function ($query) use ($search) {
               $query->where('name', 'like', "%{$search}%")
                   ->orWhere('username', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%")
                   ->orWhere('telegram', 'like', "%{$search}%")
                   ->orWhereHas('roles', function ($query) use ($search) {
                       $query->where('name', 'like', "%{$search}%");
                   });
           });
       }

        // Individual field filters
        if ($request->filled('name')) {
            $builder->where('name', 'like', '%' . $request->get('name') . '%');
        }

        if ($request->filled('username')) {
            $builder->where('username', 'like', '%' . $request->get('username') . '%');
        }

        if ($request->filled('email')) {
            $builder->where('email', 'like', '%' . $request->get('email') . '%');
        }

        if ($request->filled('telegram')) {
            $builder->where('telegram', 'like', '%' . $request->get('telegram') . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            //$builder->where('status', (bool)$request->get('status'));
        }

        // Role filters
        if ($request->filled('role_id')) {
            $builder->whereHas('roles', function ($query) use ($request) {
                $query->where('id', $request->get('role_id'));
            });
        }

        if ($request->filled('role_name')) {
            $roleName = $request->get('role_name');
            $builder->whereHas('roles', function ($query) use ($roleName) {
                $query->where('name', 'like', "%{$roleName}%");
            });
        }

        // Date filters
        if ($request->filled('created_from')) {
            $builder->where('created_at', '>=', $request->get('created_from'));
        }

        if ($request->filled('created_to')) {
            $builder->where('created_at', '<=', $request->get('created_to'));
        }
    }
}
