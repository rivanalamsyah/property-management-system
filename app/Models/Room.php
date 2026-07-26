<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'floor' => 'integer',
        'monthly_rent' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'max_occupants' => 'integer',
        'display_order' => 'integer',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Enforce workspace tenant isolation via boarding house ownership
        static::addGlobalScope('tenant', function (Builder $builder) {
            $builder->whereHas('boardingHouse');
        });
    }

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

    /**
     * Get active cover image or fallback image.
     */
    public function getCoverImagePath(): string
    {
        $cover = $this->images()->where('is_cover', true)->first();
        if ($cover) {
            return $cover->file_path;
        }

        $first = $this->images()->first();
        return $first ? $first->file_path : '';
    }
}
