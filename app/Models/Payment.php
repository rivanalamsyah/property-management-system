<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'invoice_id',
        'contract_id',
        'resident_id',
        'boarding_house_id',
        'transaction_number',
        'reference_number',
        'payment_date',
        'payment_method',
        'amount_paid',
        'admin_fee',
        'penalty_paid',
        'notes',
        'proof_of_payment_path',
        'status',
        'verified_by',
        'verified_at',
        'reconciliation_notes',
    ];

    protected $casts = [
        'status'          => PaymentStatus::class,
        'payment_method'  => PaymentMethod::class,
        'payment_date'    => 'date',
        'amount_paid'     => 'decimal:2',
        'admin_fee'       => 'decimal:2',
        'penalty_paid'    => 'decimal:2',
        'verified_at'     => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Payment $payment) {
            if (empty($payment->transaction_number)) {
                $payment->transaction_number = static::generateNumber($payment->tenant_id, 'TXN');
            }
        });
    }

    /**
     * Thread-safe transaction number generator using SELECT FOR UPDATE.
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

    public function scopeCompleted($query)
    {
        return $query->where('status', PaymentStatus::COMPLETED);
    }

    public function scopeWaitingVerification($query)
    {
        return $query->where('status', PaymentStatus::WAITING_VERIFICATION);
    }

    public function scopeForCurrentMonth($query)
    {
        return $query->whereMonth('payment_date', now()->month)
                     ->whereYear('payment_date', now()->year);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Total amount paid including admin fee.
     */
    public function getTotalPaidAttribute(): float
    {
        return (float) $this->amount_paid + (float) $this->admin_fee;
    }

    /**
     * Whether proof of payment is attached.
     */
    public function getHasProofAttribute(): bool
    {
        return !empty($this->proof_of_payment_path);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(PaymentTimeline::class)->orderBy('created_at', 'desc');
    }
}
