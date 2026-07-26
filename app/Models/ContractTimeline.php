<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'event',
        'title',
        'description',
        'icon',
        'color',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
