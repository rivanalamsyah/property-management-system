<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'room_id',
        'resident_id',
        'contract_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'billing_period_start',
        'billing_period_end',
        'subtotal',
        'discount',
        'penalty',
        'grand_total',
        'status',
        'notes',
    ];

    protected $casts = [
        'status'                => InvoiceStatus::class,
        'invoice_date'          => 'date',
        'due_date'              => 'date',
        'billing_period_start'  => 'date',
        'billing_period_end'    => 'date',
        'subtotal'              => 'decimal:2',
        'discount'              => 'decimal:2',
        'penalty'               => 'decimal:2',
        'grand_total'           => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = static::generateNumber($invoice->tenant_id, 'INV');
            }
        });
    }

    /**
     * Thread-safe sequence number generator using SELECT FOR UPDATE.
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
        return $query->where('status', InvoiceStatus::PENDING);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', InvoiceStatus::OVERDUE);
    }

    public function scopePaid($query)
    {
        return $query->where('status', InvoiceStatus::PAID);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    public function scopeForCurrentMonth($query)
    {
        return $query->whereMonth('invoice_date', now()->month)
                     ->whereYear('invoice_date', now()->year);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Whether this invoice is currently overdue (regardless of status field).
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date?->isPast() && !in_array($this->status, [
            InvoiceStatus::PAID,
            InvoiceStatus::CANCELLED,
            InvoiceStatus::VOIDED,
        ]);
    }

    /**
     * Net payable amount after discount.
     */
    public function getNetTotalAttribute(): float
    {
        return max(0, (float) $this->grand_total);
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

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(InvoiceTimeline::class)->orderBy('created_at', 'desc');
    }
}
