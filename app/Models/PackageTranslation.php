<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'locale',
        'name',
        'slug',
        'description',
        'features',
    ];

    /**
     * Get the package that owns the translation.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
