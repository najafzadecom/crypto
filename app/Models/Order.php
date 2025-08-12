<?php

namespace App\Models;

use App\Models\Scopes\OrderScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'billing_details' => 'array',
        'metadata' => 'array',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the package for the order.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the transactions for the order.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the order's status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info', 
            'completed' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary'
        ];

        $color = $colors[$this->status] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->status) . '</span>';
    }

    /**
     * Get the payment status badge HTML.
     */
    public function getPaymentStatusBadgeAttribute(): string
    {
        $colors = [
            'unpaid' => 'danger',
            'paid' => 'success',
            'partially_paid' => 'warning',
            'refunded' => 'secondary'
        ];

        $color = $colors[$this->payment_status] ?? 'secondary';
        return '<span class="badge bg-' . $color . '">' . ucfirst(str_replace('_', ' ', $this->payment_status)) . '</span>';
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.order.index')) {
            static::addGlobalScope(new OrderScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
