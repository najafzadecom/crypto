<?php

namespace App\Models;

use App\Models\Scopes\CountryScope;
use App\Traits\HasStatusHtml;
use App\Traits\HasTranslatedAttributes;
use App\Traits\Sortable;
use Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    /** @use HasFactory<CountryFactory> */
    use HasFactory, HasStatusHtml, HasTranslatedAttributes, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    protected $with = ['translations'];

    /**
     * Get the translations for the country.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CountryTranslation::class);
    }

    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return CountryTranslation::class;
    }

    /**
     * Get the regions for this country.
     */
    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.countries.index')) {
            static::addGlobalScope(new CountryScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
