<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'event',
        'title',
        'description',
        'icon',
        'color',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
