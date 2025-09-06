<?php

namespace App\Models;

use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BalanceTransaction extends Model
{
    use HasFactory, SoftDeletes, Sortable, HasStatusHtml, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sender user for the transaction.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    /**
     * Get the transaction's status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary'
        ];

        $color = $colors[$this->status] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->status) . '</span>';
    }

    /**
     * Get the transaction's type badge HTML.
     */
    public function getTypeBadgeAttribute(): string
    {
        $colors = [
            'deposit' => 'primary',
            'withdrawal' => 'info',
            'transfer_in' => 'success',
            'transfer_out' => 'warning',
            'admin_adjustment' => 'dark'
        ];

        $color = $colors[$this->type] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst(str_replace('_', ' ', $this->type)) . '</span>';
    }

    /**
     * Mark the transaction as completed.
     */
    public function markAsCompleted(): self
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
        
        return $this;
    }

    /**
     * Mark the transaction as failed.
     */
    public function markAsFailed(string $notes = null): self
    {
        $this->status = 'failed';
        if ($notes) {
            $this->notes = $notes;
        }
        $this->save();
        
        return $this;
    }

    /**
     * Mark the transaction as cancelled.
     */
    public function markAsCancelled(string $notes = null): self
    {
        $this->status = 'cancelled';
        if ($notes) {
            $this->notes = $notes;
        }
        $this->save();
        
        return $this;
    }

    /**
     * Generate a unique transaction ID.
     */
    public static function generateTransactionId(): string
    {
        return 'TRX' . strtoupper(uniqid());
    }
}
