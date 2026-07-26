<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'icon',
        'category',
        'description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (empty($model->tenant_id) && function_exists('tenant') && tenant()) {
                $model->tenant_id = tenant()->id;
            }
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->name);
            }
            if (empty($model->category)) {
                $model->category = 'general';
            }
        });
    }

    /**
     * Scope query to only include facilities relevant to current tenant (or global defaults).
     */
    public function scopeForCurrentTenant(Builder $query): Builder
    {
        if (function_exists('tenant') && tenant()) {
            return $query->where(function ($q) {
                $q->where('tenant_id', tenant()->id)
                  ->orWhereNull('tenant_id');
            });
        }

        return $query->whereNull('tenant_id');
    }

    public function boardingHouses(): BelongsToMany
    {
        return $this->belongsToMany(BoardingHouse::class, 'boarding_house_facility')
            ->withPivot('is_featured')
            ->withTimestamps();
    }
}
