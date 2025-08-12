<?php

namespace App\Models;

use App\Models\Scopes\CategoryScope;
use App\Traits\HasStatusHtml;
use App\Observers\RoleObserver;
use App\Policies\RolePolicy;
use App\Traits\Sortable;
use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Blade;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy([RoleObserver::class])]
#[UsePolicy(RolePolicy::class)]
class Role extends \Spatie\Permission\Models\Role
{
    /** @use HasFactory<RoleFactory> */
    use HasFactory, SoftDeletes, Sortable, HasStatusHtml, LogsActivity;

    protected $guarded = [];

    protected $appends = ['coloredName'];

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.roles.index')) {
            static::addGlobalScope(new CategoryScope());
        }
    }

    public function getColoredNameAttribute(): string
    {
        return Blade::render('<x-badge :color="$color" :title="$title" />', [
            'title' => $this->name,
            'color' => $this->color ?? 'bg-dark'
        ]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
