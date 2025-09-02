<?php

namespace App\Models;

use App\Models\Scopes\SliderScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\SliderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    /** @use HasFactory<SliderFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    protected $with = ['translations'];

    /**
     * Get the translations for the slider.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(SliderTranslation::class);
    }

    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return SliderTranslation::class;
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.slider.index')) {
            static::addGlobalScope(new SliderScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
