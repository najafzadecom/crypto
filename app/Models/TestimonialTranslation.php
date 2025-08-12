<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestimonialTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'testimonial_id',
        'locale',
        'name',
        'slug',
        'position',
        'comment',
    ];

    /**
     * Get the testimonial that owns the translation.
     */
    public function testimonial(): BelongsTo
    {
        return $this->belongsTo(Testimonial::class);
    }
}
