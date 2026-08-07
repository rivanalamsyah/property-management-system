<?php

namespace App\Models;

use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Complaint extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'room_id',
        'resident_id',
        'complaint_number',
        'category',
        'priority',
        'status',
        'subject',
        'description',
        'internal_notes',
        'is_tenant_visible',
    ];

    protected $casts = [
        'priority'          => ComplaintPriority::class,
        'status'            => ComplaintStatus::class,
        'is_tenant_visible' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Complaint $complaint) {
            if (empty($complaint->complaint_number)) {
                $complaint->complaint_number = static::generateNumber($complaint->tenant_id, 'CMP');
            }
        });
    }

    /**
     * Thread-safe complaint number generator using SELECT FOR UPDATE.
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

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeOpen($query)
    {
        return $query->where('status', ComplaintStatus::OPEN);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', [
            ComplaintStatus::OPEN,
            ComplaintStatus::ASSIGNED,
            ComplaintStatus::IN_PROGRESS,
        ]);
    }

    public function scopeResolved($query)
    {
        return $query->where('status', ComplaintStatus::RESOLVED);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', ComplaintPriority::HIGH)
                     ->orWhere('priority', ComplaintPriority::CRITICAL);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Whether the complaint is still open/active.
     */
    public function getIsActiveAttribute(): bool
    {
        return in_array($this->status, [
            ComplaintStatus::OPEN,
            ComplaintStatus::ASSIGNED,
            ComplaintStatus::IN_PROGRESS,
        ]);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ComplaintAttachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ComplaintComment::class)->orderBy('created_at', 'asc');
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(ComplaintTimeline::class)->orderBy('created_at', 'desc');
    }

    public function maintenanceTask(): HasOne
    {
        return $this->hasOne(MaintenanceTask::class);
    }
}
