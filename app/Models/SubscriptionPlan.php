<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'max_rooms',
        'max_tenants',
        'max_staff',
        'max_branches',
        'storage_limit_mb',
        'max_upload_size_mb',
        'has_reports',
        'has_analytics',
        'has_resident_portal',
        'has_maintenance',
        'has_announcements',
        'feature_flags',
        'is_active',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'max_rooms' => 'integer',
        'max_tenants' => 'integer',
        'max_staff' => 'integer',
        'max_branches' => 'integer',
        'storage_limit_mb' => 'integer',
        'max_upload_size_mb' => 'integer',
        'has_reports' => 'boolean',
        'has_analytics' => 'boolean',
        'has_resident_portal' => 'boolean',
        'has_maintenance' => 'boolean',
        'has_announcements' => 'boolean',
        'feature_flags' => 'array',
        'is_active' => 'boolean',
    ];

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
