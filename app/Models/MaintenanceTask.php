<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class MaintenanceTask extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'complaint_id',
        'task_number',
        'assigned_staff_id',
        'assigned_at',
        'estimated_completion_date',
        'actual_completion_date',
        'repair_notes',
        'replacement_parts',
        'cost',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'estimated_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'cost' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (MaintenanceTask $task) {
            if (empty($task->task_number)) {
                $task->task_number = static::generateNumber($task->tenant_id, 'MNT');
            }
        });
    }

    /**
     * Thread-safe task number generator using SELECT FOR UPDATE.
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

    public function scopePending($query)
    {
        return $query->whereNull('actual_completion_date');
    }

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('actual_completion_date');
    }

    public function scopeAssignedToStaff($query, int $staffId)
    {
        return $query->where('assigned_staff_id', $staffId);
    }

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    public function checklists(): HasMany
    {
        return $this->hasMany(MaintenanceChecklist::class);
    }
}
