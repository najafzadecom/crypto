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
            'birth_date' => 'date',
            'profile_blocked_until' => 'datetime',
            'last_profile_update' => 'datetime',
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
    
    /**
     * Get the birth country of the user.
     */
    public function birthCountry(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'birth_country_id');
    }
    
    /**
     * Get the birth region of the user.
     */
    public function birthRegion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class, 'birth_region_id');
    }
    
    /**
     * Get the residence country of the user.
     */
    public function residenceCountry(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'residence_country_id');
    }
    
    /**
     * Get the residence region of the user.
     */
    public function residenceRegion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class, 'residence_region_id');
    }
    
    /**
     * Check if the user's profile is currently blocked.
     */
    public function isProfileBlocked(): bool
    {
        if (!$this->profile_blocked_until) {
            return false;
        }
        
        return now()->lt($this->profile_blocked_until);
    }
    
    /**
     * Block the user's profile for the specified number of hours.
     */
    public function blockProfile(int $hours = 48): self
    {
        $this->profile_blocked_until = now()->addHours($hours);
        $this->save();
        
        return $this;
    }
    
    /**
     * Unblock the user's profile.
     */
    public function unblockProfile(): self
    {
        $this->profile_blocked_until = null;
        $this->save();
        
        return $this;
    }
    
    /**
     * Validate wallet address format.
     */
    public static function isValidWalletAddress(string $address): bool
    {
        // BEP20 wallet addresses are 42 characters long and start with 0x
        return (bool) preg_match('/^0x[a-fA-F0-9]{40}$/', $address);
    }
    
    /**
     * Get the user's balances.
     */
    public function balances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Balance::class);
    }
    
    /**
     * Get the user's balance transactions.
     */
    public function balanceTransactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BalanceTransaction::class);
    }
    
    /**
     * Get the user's sent balance transactions.
     */
    public function sentBalanceTransactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BalanceTransaction::class, 'sender_id');
    }
    
    /**
     * Get or create a balance for the specified currency.
     */
    public function getOrCreateBalance(string $currency = 'AZN'): Balance
    {
        $balance = $this->balances()->firstWhere('currency', $currency);
        
        if (!$balance) {
            $balance = $this->balances()->create([
                'currency' => $currency,
                'amount' => 0
            ]);
        }
        
        return $balance;
    }
}
