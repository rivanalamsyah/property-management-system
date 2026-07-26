<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsRedirect extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'source_path',
        'target_path',
        'status_code',
        'is_active',
    ];

    protected $casts = [
        'status_code' => 'integer',
        'is_active' => 'boolean',
    ];
}
