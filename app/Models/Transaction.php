<?php

namespace App\Models;

use App\Models\Scopes\TransactionScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'gateway_response' => 'array',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order for the transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the transaction's status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'refunded' => 'dark'
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
            'payment' => 'primary',
            'refund' => 'warning',
            'chargeback' => 'danger',
            'fee' => 'info'
        ];

        $color = $colors[$this->type] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->type) . '</span>';
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.transaction.index')) {
            static::addGlobalScope(new TransactionScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
