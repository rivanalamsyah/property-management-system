<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardingHouseRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id',
        'category',
        'title',
        'description',
        'icon',
        'display_order',
        'is_active',
        'is_visible_public',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_visible_public' => 'boolean',
        'display_order' => 'integer',
    ];

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
