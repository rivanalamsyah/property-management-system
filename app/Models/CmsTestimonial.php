<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsTestimonial extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_name',
        'avatar',
        'company',
        'position',
        'rating',
        'review',
        'display_order',
        'is_visible',
    ];

    protected $casts = [
        'rating' => 'integer',
        'display_order' => 'integer',
        'is_visible' => 'boolean',
    ];
}
