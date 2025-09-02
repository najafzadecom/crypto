<?php

namespace App\Models;

use App\Models\Scopes\StaticBlockScope;
use App\Traits\HasStatusHtml;
use App\Traits\HasTranslatedAttributes;
use App\Traits\Sortable;
use Database\Factories\StaticBlockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class StaticBlock extends Model
{
    /** @use HasFactory<StaticBlockFactory> */
    use HasFactory, HasStatusHtml, HasTranslatedAttributes, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    protected $with = ['translations'];

    /**
     * Get the translations for the static block.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(StaticBlockTranslation::class);
    }

    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return StaticBlockTranslation::class;
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.static-block.index')) {
            static::addGlobalScope(new StaticBlockScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
