<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\LanguageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Language extends Model
{
    /** @use HasFactory<LanguageFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity;

    protected $guarded = [];

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.language.index')) {
            static::addGlobalScope(new LanguageScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
