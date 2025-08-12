<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_id',
        'locale',
        'title',
        'slug',
        'subtitle',
        'description',
        'button_text',
    ];

    /**
     * Get the slider that owns the translation.
     */
    public function slider(): BelongsTo
    {
        return $this->belongsTo(Slider::class);
    }
}
