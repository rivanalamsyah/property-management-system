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
use Illuminate\Support\Facades\DB;

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

    protected static function booted(): void
    {
        static::creating(function (Announcement $announcement) {
            if (empty($announcement->announcement_number)) {
                $announcement->announcement_number = static::generateNumber($announcement->tenant_id, 'ANN');
            }
        });
    }

    /**
     * Thread-safe announcement number generator using SELECT FOR UPDATE.
     */
    public static function generateNumber(string $tenantId, string $prefix): string
    {
        return DB::transaction(function () use ($tenantId, $prefix) {
            $year = date('Y');
            $count = static::where('tenant_id', $tenantId)
                ->whereYear('created_at', $year)
                ->lockForUpdate()
                ->count();
            $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            return "{$prefix}-{$year}-{$sequence}";
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
