<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'room_id',
        'resident_id',
        'contract_number',
        'contract_type',
        'status',
        'start_date',
        'end_date',
        'move_in_date',
        'move_out_date',
        'duration_months',
        'auto_renewal',
        'monthly_rent',
        'security_deposit',
        'electricity_fee',
        'water_fee',
        'internet_fee',
        'parking_fee',
        'additional_charges',
        'discount',
        'internal_notes',
        'public_notes',
        'signed_pdf_path',
        'version',
    ];

    protected $attributes = [
        'version' => 1,
    ];

    protected $casts = [
        'contract_type' => ContractType::class,
        'status' => ContractStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'move_in_date' => 'date',
        'move_out_date' => 'date',
        'auto_renewal' => 'boolean',
        'monthly_rent' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'electricity_fee' => 'decimal:2',
        'water_fee' => 'decimal:2',
        'internet_fee' => 'decimal:2',
        'parking_fee' => 'decimal:2',
        'additional_charges' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($contract) {
            if (empty($contract->contract_number)) {
                $year = date('Y');
                // Calculate next increment offset under workspace
                $count = static::where('tenant_id', $contract->tenant_id)
                    ->whereYear('created_at', $year)
                    ->count();
                
                $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
                $contract->contract_number = "CTR-{$year}-{$sequence}";
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

    public function versions(): HasMany
    {
        return $this->hasMany(ContractVersion::class)->orderBy('version_number', 'desc');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ContractAttachment::class);
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(ContractTimeline::class)->orderBy('created_at', 'desc');
    }
}
