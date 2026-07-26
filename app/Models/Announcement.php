<?php

namespace App\Models;

use App\Enums\AnnouncementPriority;
use App\Enums\AnnouncementStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'announcement_number',
        'title',
        'summary',
        'content',
        'category',
        'priority',
        'status',
        'target_type',
        'target_filters',
        'publish_at',
        'expires_at',
        'pinned_at',
        'author_id',
        'attachment_path',
        'attachment_name',
    ];

    protected $casts = [
        'priority' => AnnouncementPriority::class,
        'status' => AnnouncementStatus::class,
        'target_filters' => 'array',
        'publish_at' => 'datetime',
        'expires_at' => 'datetime',
        'pinned_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($announcement) {
            if (empty($announcement->announcement_number)) {
                $year = date('Y');
                // Calculate next increment offset under active workspace
                $count = static::where('tenant_id', $announcement->tenant_id)
                    ->whereYear('created_at', $year)
                    ->count();
                
                $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
                $announcement->announcement_number = "ANN-{$year}-{$sequence}";
            }
        });
    }

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function readReceipts(): HasMany
    {
        return $this->hasMany(AnnouncementReadReceipt::class);
    }
}
