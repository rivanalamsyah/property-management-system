<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsFaq extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cms_faqs';

    protected $fillable = [
        'category',
        'question',
        'answer',
        'display_order',
        'is_visible',
    ];

    protected $casts = [
        'display_order' => 'integer',
        'is_visible' => 'boolean',
    ];
}
