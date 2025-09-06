<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Balance extends Model
{
    use HasFactory, SoftDeletes, Sortable, LogsActivity;

    protected $guarded = [];

    /**
     * Get the user that owns the balance.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    /**
     * Increase the balance amount.
     */
    public function increase(float $amount): self
    {
        $this->amount += $amount;
        $this->save();
        
        return $this;
    }

    /**
     * Decrease the balance amount.
     */
    public function decrease(float $amount): self
    {
        if ($this->amount < $amount) {
            throw new \Exception('Kifayət qədər balans yoxdur');
        }
        
        $this->amount -= $amount;
        $this->save();
        
        return $this;
    }

    /**
     * Check if the balance has enough amount.
     */
    public function hasEnough(float $amount): bool
    {
        return $this->amount >= $amount;
    }
}
