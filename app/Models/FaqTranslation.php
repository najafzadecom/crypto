<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_id',
        'locale',
        'question',
        'answer',
    ];

    /**
     * Get the faq that owns the translation.
     */
    public function faq(): BelongsTo
    {
        return $this->belongsTo(Faq::class);
    }
}
