<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'building',
        'floor',
        'room',
        'description',
    ];

    /**
     * Get the assets for the location.
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}