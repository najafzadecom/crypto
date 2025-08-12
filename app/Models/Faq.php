<?php

namespace App\Models;

use App\Models\Scopes\FaqScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    /** @use HasFactory<FaqFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    /**
    /**
     * Get the translations for the faq.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return FaqTranslation::class;
    }

    /**
    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.faq.index')) {
            static::addGlobalScope(new FaqScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
