<?php

namespace App\Models;

use App\Enums\CmsPublishStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsPage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'seo_title',
        'seo_description',
        'seo_meta',
        'status',
        'published_at',
        'expired_at',
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'status' => CmsPublishStatus::class,
        'published_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(CmsSection::class)->orderBy('display_order');
    }
}
