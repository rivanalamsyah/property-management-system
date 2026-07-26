<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsSection extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'cms_page_id',
        'type',
        'name',
        'content',
        'display_order',
        'is_visible',
    ];

    protected $casts = [
        'content' => 'array',
        'is_visible' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(CmsPage::class, 'cms_page_id');
    }
}
