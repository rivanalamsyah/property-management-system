<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResidentTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'event',
        'title',
        'description',
        'icon',
        'color',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
