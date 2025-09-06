<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'locale',
        'name'
    ];

    /**
     * Get the country that owns the translation.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
