<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\UserScope;
use App\Observers\UserObserver;
use App\Policies\UserPolicy;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Blade;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
#[UsePolicy(UserPolicy::class)]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, Sortable, HasRoles, HasStatusHtml, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    protected $with = ['roles'];

    protected $appends = ['coloredRoleNames'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        if (request()->isMethod('GET') && request()->routeIs('admin.users.index')) {
            //static::addGlobalScope(new UserScope());
        }
    }

    public function getColoredRoleNamesAttribute(): string
    {
        return $this->roles->map(function ($role) {
            return Blade::render('<x-badge :color="$color" :title="$title" />', [
                'title' => $role->name,
                'color' => $role->color ?? 'bg-dark',
            ]);
        })->implode('<br/>');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}
