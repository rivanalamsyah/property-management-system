<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsRevision extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false; // created_at only

    protected $fillable = [
        'revisable_type',
        'revisable_id',
        'content',
        'user_id',
        'version_number',
        'created_at',
    ];

    protected $casts = [
        'content' => 'array',
        'version_number' => 'integer',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
