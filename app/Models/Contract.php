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
use Illuminate\Support\Facades\DB;

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
        'contract_type'     => ContractType::class,
        'status'            => ContractStatus::class,
        'start_date'        => 'date',
        'end_date'          => 'date',
        'move_in_date'      => 'date',
        'move_out_date'     => 'date',
        'auto_renewal'      => 'boolean',
        'monthly_rent'      => 'decimal:2',
        'security_deposit'  => 'decimal:2',
        'electricity_fee'   => 'decimal:2',
        'water_fee'         => 'decimal:2',
        'internet_fee'      => 'decimal:2',
        'parking_fee'       => 'decimal:2',
        'additional_charges'=> 'decimal:2',
        'discount'          => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Contract $contract) {
            if (empty($contract->contract_number)) {
                $contract->contract_number = static::generateNumber($contract->tenant_id, 'CTR');
            }
        });
    }

    /**
     * Thread-safe contract number generator using SELECT FOR UPDATE.
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

    public function scopeActive($query)
    {
        return $query->where('status', ContractStatus::ACTIVE);
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->where('status', ContractStatus::ACTIVE)
                     ->whereNotNull('end_date')
                     ->whereDate('end_date', '<=', now()->addDays($days))
                     ->whereDate('end_date', '>=', now());
    }

    public function scopeForResident($query, string $residentId)
    {
        return $query->where('resident_id', $residentId);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Sum of all recurring monthly charges.
     */
    public function getTotalMonthlyChargesAttribute(): float
    {
        return (float) $this->monthly_rent
            + (float) $this->electricity_fee
            + (float) $this->water_fee
            + (float) $this->internet_fee
            + (float) $this->parking_fee
            + (float) $this->additional_charges
            - (float) $this->discount;
    }

    /**
     * Whether this contract is still running.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === ContractStatus::ACTIVE;
    }

    /**
     * Days remaining until contract end (null = open-ended).
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (!$this->end_date) {
            return null;
        }
        return max(0, (int) now()->diffInDays($this->end_date, false));
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

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class)->orderBy('invoice_date', 'desc');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->orderBy('payment_date', 'desc');
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
