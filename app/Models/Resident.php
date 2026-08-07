<?php

namespace App\Models;

use App\Enums\ResidentStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resident extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'boarding_house_id',
        'room_id',
        'name',
        'nik',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'occupation',
        'marital_status',
        'religion',
        'photo',
        'phone',
        'whatsapp',
        'email',
        'emergency_name',
        'emergency_relationship',
        'emergency_phone',
        'emergency_address',
        'province',
        'city',
        'district',
        'postal_code',
        'address',
        'status',
        'check_in_date',
        'move_in_time',
        'initial_meter_reading',
        'security_deposit',
        'check_in_notes',
        'check_out_date',
        'final_meter_reading',
        'check_out_notes',
        'damage_notes',
    ];

    protected $casts = [
        'status'                => ResidentStatus::class,
        'date_of_birth'         => 'date',
        'check_in_date'         => 'date',
        'check_out_date'        => 'date',
        'initial_meter_reading' => 'decimal:2',
        'final_meter_reading'   => 'decimal:2',
        'security_deposit'      => 'decimal:2',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', ResidentStatus::ACTIVE);
    }

    public function scopePending($query)
    {
        return $query->where('status', ResidentStatus::PENDING);
    }

    public function scopeFormer($query)
    {
        return $query->where('status', ResidentStatus::FORMER);
    }

    public function scopeWithActiveContract($query)
    {
        return $query->whereHas('activeContract');
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Preferred contact number — WhatsApp if available, else phone.
     */
    public function getContactNumberAttribute(): ?string
    {
        return $this->whatsapp ?: $this->phone;
    }

    /**
     * Full address string.
     */
    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->address,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code,
        ]));
    }

    /**
     * Whether the resident is currently occupying a room.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === ResidentStatus::ACTIVE;
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

    public function documents(): HasMany
    {
        return $this->hasMany(ResidentDocument::class);
    }

    public function timeline(): HasMany
    {
        return $this->hasMany(ResidentTimeline::class)->orderBy('created_at', 'desc');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class)->orderBy('created_at', 'desc');
    }

    public function activeContract(): HasOne
    {
        return $this->hasOne(Contract::class)->where('status', \App\Enums\ContractStatus::ACTIVE);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class)->orderBy('invoice_date', 'desc');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->orderBy('payment_date', 'desc');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class)->orderBy('created_at', 'desc');
    }

    public function announcements()
    {
        return $this->hasMany(AnnouncementReadReceipt::class);
    }
}
