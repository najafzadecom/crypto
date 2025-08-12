<?php

namespace App\Models;

use App\Models\Scopes\TestimonialScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    /**
     * Get the translations for the testimonial.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(TestimonialTranslation::class);
    }

    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return TestimonialTranslation::class;
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.testimonial.index')) {
            static::addGlobalScope(new TestimonialScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}