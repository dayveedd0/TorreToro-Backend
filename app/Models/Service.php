<?php

namespace App\Models;

use App\Models\Traits\BelongsToDomain;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use BelongsToDomain;

    protected $fillable = [
        'domain_id',
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'description',
        'icon',
        'thumbnail_image',
        'banner_image',
        'gallery_images',
        'features',
        'order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
