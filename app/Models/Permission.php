<?php

namespace App\Models;

use App\Models\Scopes\PermissionScope;
use App\Observers\PermissionObserver;
use App\Policies\PermissionPolicy;
use App\Traits\Sortable;
use Database\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy([PermissionObserver::class])]
#[UsePolicy(PermissionPolicy::class)]
class Permission extends \Spatie\Permission\Models\Permission
{
    /** @use HasFactory<PermissionFactory> */
    use HasFactory, SoftDeletes, Sortable, LogsActivity;

    protected $guarded = [];

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.permissions.index')) {
            static::addGlobalScope(new PermissionScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}
