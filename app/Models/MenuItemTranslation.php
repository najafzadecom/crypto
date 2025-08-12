<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItemTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'locale',
        'title',
        'slug',
    ];

    /**
     * Get the menu item that owns the translation.
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
}
