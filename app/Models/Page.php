<?php

namespace App\Models;

use App\Models\Scopes\PageScope;
use App\Traits\HasStatusHtml;
use App\Traits\HasTranslatedAttributes;
use App\Traits\Sortable;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory, HasStatusHtml, HasTranslatedAttributes, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    protected $with = ['translations'];

    /**
     * Get the translations for the page.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return PageTranslation::class;
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.page.index')) {
            static::addGlobalScope(new PageScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
