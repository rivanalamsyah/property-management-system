<?php

namespace App\Models;

use App\Enums\CmsPublishStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CmsBlogArticle extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_name',
        'status',
        'published_at',
        'expired_at',
        'seo_title',
        'seo_description',
        'seo_meta',
    ];

    protected $casts = [
        'status' => CmsPublishStatus::class,
        'published_at' => 'datetime',
        'expired_at' => 'datetime',
        'seo_meta' => 'array',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CmsBlogCategory::class, 'cms_article_category', 'article_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(CmsBlogTag::class, 'cms_article_tag', 'article_id', 'tag_id');
    }
}
