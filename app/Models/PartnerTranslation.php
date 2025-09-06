<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'locale',
        'name',
        'description',
        'website',
    ];

    /**
     * Get the partner that owns the translation.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
