<?php

namespace App\Models;

use App\Models\Scopes\MenuScope;
use App\Traits\HasStatusHtml;
use App\Traits\Sortable;
use Database\Factories\MenuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    /** @use HasFactory<MenuFactory> */
    use HasFactory, HasStatusHtml, SoftDeletes, Sortable, LogsActivity, HasTranslations;

    protected $guarded = [];

    /**
     * Get the translations for the menu.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(MenuTranslation::class);
    }

    /**
     * Get the menu items for the menu.
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get the translation model for Spatie Translatable.
     */
    public function getTranslationModelName(): string
    {
        return MenuTranslation::class;
    }

    /**
     * Apply global scopes to the model.
     */
    protected static function booted(): void
    {
        parent::booted();

        if (request()->isMethod('GET') && request()->routeIs('admin.menu.index')) {
            static::addGlobalScope(new MenuScope());
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }
}
