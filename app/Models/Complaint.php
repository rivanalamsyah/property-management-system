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
        'priority' => ComplaintPriority::class,
        'status' => ComplaintStatus::class,
        'is_tenant_visible' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($complaint) {
            if (empty($complaint->complaint_number)) {
                $year = date('Y');
                // Calculate next increment offset under active workspace
                $count = static::where('tenant_id', $complaint->tenant_id)
                    ->whereYear('created_at', $year)
                    ->count();
                
                $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
                $complaint->complaint_number = "CMP-{$year}-{$sequence}";
            }
        });
    }

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
