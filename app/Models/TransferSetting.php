<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TransferSetting extends Model
{
    use HasFactory, Sortable, LogsActivity;

    protected $guarded = [];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    /**
     * Calculate the fee for a transfer amount.
     */
    public function calculateFee(float $amount): float
    {
        $percentageFee = $amount * ($this->fee_percentage / 100);
        return $percentageFee + $this->fee_fixed;
    }

    /**
     * Check if the amount is within the allowed limits.
     */
    public function isAmountValid(float $amount): bool
    {
        return $amount >= $this->min_amount && $amount <= $this->max_amount;
    }
}
