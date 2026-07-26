<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardingHouseGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'boarding_house_id',
        'file_path',
        'is_cover',
        'display_order',
        'label',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'display_order' => 'integer',
    ];

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }
}
