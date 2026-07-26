<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'event',
        'title',
        'description',
        'icon',
        'color',
    ];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }
}
