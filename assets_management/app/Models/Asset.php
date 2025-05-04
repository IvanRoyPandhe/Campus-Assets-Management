<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asset_code',
        'name',
        'category',
        'location_id',
        'condition',
        'description',
        'purchase_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'date',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate a unique asset code when creating a new asset
        static::creating(function ($asset) {
            $asset->asset_code = 'ASSET-' . time() . '-' . rand(1000, 9999);
        });
    }

    /**
     * Get the location that owns the asset.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}