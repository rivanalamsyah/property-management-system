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
        'status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'penalty_paid' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($payment) {
            if (empty($payment->transaction_number)) {
                $year = date('Y');
                // Calculate next increment offset under active workspace
                $count = static::where('tenant_id', $payment->tenant_id)
                    ->whereYear('created_at', $year)
                    ->count();
                
                $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
                $payment->transaction_number = "TXN-{$year}-{$sequence}";
            }
        });
    }

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
