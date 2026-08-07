<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'boarding_house_id',
        'room_number',
        'room_name',
        'floor',
        'building_block',
        'room_type',
        'monthly_rent',
        'security_deposit',
        'room_size',
        'max_occupants',
        'gender_restriction',
        'status',
        'description',
        'internal_notes',
        'display_order',
        'room_code',
        'qr_code_path',
        'is_published',
    ];

    protected $casts = [
        'floor'         => 'integer',
        'monthly_rent'  => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'max_occupants' => 'integer',
        'display_order' => 'integer',
        'is_published'  => 'boolean',
    ];

    protected static function booted(): void
    {
        // Enforce workspace tenant isolation via boarding house ownership
        static::addGlobalScope('tenant', function (Builder $builder) {
            $builder->whereHas('boardingHouse');
        });
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeForFloor($query, int $floor)
    {
        return $query->where('floor', $floor);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Whether the room is currently vacant.
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Human-readable room label (number + name).
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->room_name && $this->room_name !== $this->room_number) {
            return "#{$this->room_number} — {$this->room_name}";
        }
        return "Kamar #{$this->room_number}";
    }

    /**
     * Get active cover image or fallback image.
     */
    public function getCoverImagePath(): string
    {
        if ($this->relationLoaded('images')) {
            $cover = $this->images->firstWhere('is_cover', true);
            if ($cover) {
                return $cover->file_path;
            }
            $first = $this->images->first();
            return $first ? $first->file_path : '';
        }

        $cover = $this->images()->where('is_cover', true)->first();
        if ($cover) {
            return $cover->file_path;
        }

        $first = $this->images()->first();
        return $first ? $first->file_path : '';
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'room_facility')
            ->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class)->orderBy('display_order');
    }

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function activeResident(): HasOne
    {
        return $this->hasOne(Resident::class)->where('status', \App\Enums\ResidentStatus::ACTIVE);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class)->orderBy('start_date', 'desc');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class)->orderBy('invoice_date', 'desc');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class)->orderBy('created_at', 'desc');
    }
}
