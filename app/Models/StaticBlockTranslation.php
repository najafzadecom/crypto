<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaticBlockTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'static_block_id',
        'locale',
        'title',
        'content',
    ];

    /**
     * Get the static block that owns the translation.
     */
    public function staticBlock(): BelongsTo
    {
        return $this->belongsTo(StaticBlock::class);
    }
}
