<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected static function booted()
    {
        static::creating(function ($task) {
            if (empty($task->task_number)) {
                $year = date('Y');
                // Calculate next increment offset under active workspace
                $count = static::where('tenant_id', $task->tenant_id)
                    ->whereYear('created_at', $year)
                    ->count();
                
                $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
                $task->task_number = "MNT-{$year}-{$sequence}";
            }
        });
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
