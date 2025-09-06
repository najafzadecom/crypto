<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegionTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'locale',
        'name'
    ];

    /**
     * Get the region that owns the translation.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
