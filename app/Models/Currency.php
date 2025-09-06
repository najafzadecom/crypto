<?php

namespace App\Models;

use App\Models\Scopes\CurrencyScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\CurrencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    /** @use HasFactory<CurrencyFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity;

    protected $guarded = [];

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.currencies.index')) {
            static::addGlobalScope(new CurrencyScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
