<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'locale',
        'name',
        'slug',
    ];

    /**
     * Get the menu that owns the translation.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
