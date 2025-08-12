<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'locale',
        'name',
        'slug',
        'description',
    ];

     /**
     * Get the category that owns the translation.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
