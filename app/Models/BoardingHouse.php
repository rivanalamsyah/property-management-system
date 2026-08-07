<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BoardingHouse extends Model
{
    use HasFactory, HasUuids, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'logo',
        'cover_image',
        'description',
        'address',
        'province',
        'city',
        'district',
        'postal_code',
        'latitude',
        'longitude',
        'whatsapp_number',
        'email',
        'operating_hours',
        'status',
        'is_public',
        'settings',
    ];

    protected $casts = [
        'is_public'  => 'boolean',
        'settings'   => 'array',
        'latitude'   => 'decimal:8',
        'longitude'  => 'decimal:8',
    ];

    /**
     * Default boarding house configuration settings.
     */
    public static function defaultSettings(): array
    {
        return [
            'check_in_time'              => '14:00',
            'check_out_time'             => '12:00',
            'billing_due_day'            => 5,
            'accepted_payment_channels'  => ['cash', 'bank_transfer'],
            'currency'                   => 'IDR',
            'timezone'                   => 'Asia/Jakarta',
            'date_format'                => 'd/m/Y',
            'number_format'              => 'id_ID',
            'invoice_prefix'             => 'INV-KOS',
            'invoice_notes'              => 'Terima kasih atas pembayaran Anda. Harap simpan bukti pembayaran ini.',
            'booking_policy'             => 'Uang muka (DP) sebesar 50% wajib dibayarkan saat memesan kamar.',
            'cancellation_policy'        => 'Pembatalan sebelum H-3 check-in dikenakan denda 20% dari total DP.',
        ];
    }

    /**
     * Helper to get a config setting value.
     */
    public function getSetting(string $key, mixed $default = null): mixed
    {
        $settings = $this->settings ?? [];
        $defaults  = self::defaultSettings();

        return array_key_exists($key, $settings)
            ? $settings[$key]
            : ($defaults[$key] ?? $default);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Total number of rooms in this property.
     */
    public function getTotalRoomsAttribute(): int
    {
        return $this->rooms()->count();
    }

    /**
     * Number of currently occupied rooms.
     */
    public function getOccupiedRoomsAttribute(): int
    {
        return $this->rooms()->where('status', 'occupied')->count();
    }

    /**
     * Occupancy rate as a percentage (0–100).
     */
    public function getOccupancyRateAttribute(): int
    {
        $total = $this->getTotalRoomsAttribute();
        if ($total === 0) return 0;
        return (int) round(($this->getOccupiedRoomsAttribute() / $total) * 100);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class)->withoutGlobalScope('tenant');
    }

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'boarding_house_facility')
            ->withPivot('is_featured')
            ->withTimestamps();
    }

    public function rules(): HasMany
    {
        return $this->hasMany(BoardingHouseRule::class)->orderBy('display_order');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(BoardingHouseGallery::class)->orderBy('display_order');
    }
}
