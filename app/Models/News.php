<?php

namespace App\Models;

use App\Models\Scopes\NewsScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    /** @use HasFactory<NewsFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    /**
    /**
     * Get the translations for the news.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(NewsTranslation::class);
    }

    /**
    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return NewsTranslation::class;
    }

    /**
    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.news.index')) {
            static::addGlobalScope(new NewsScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
