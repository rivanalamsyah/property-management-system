<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'status' => InvoiceStatus::class,
        'invoice_date' => 'date',
        'due_date' => 'date',
        'billing_period_start' => 'date',
        'billing_period_end' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'penalty' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $year = date('Y');
                // Calculate next increment offset under active workspace
                $count = static::where('tenant_id', $invoice->tenant_id)
                    ->whereYear('created_at', $year)
                    ->count();
                
                $sequence = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
                $invoice->invoice_number = "INV-{$year}-{$sequence}";
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

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(InvoiceTimeline::class)->orderBy('created_at', 'desc');
    }
}
