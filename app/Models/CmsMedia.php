<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsMedia extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'filename',
        'filepath',
        'file_url',
        'mime_type',
        'file_size',
        'folder',
        'alt_text',
        'responsive_variants',
    ];

    protected $casts = [
        'responsive_variants' => 'array',
        'file_size' => 'integer',
    ];
}
