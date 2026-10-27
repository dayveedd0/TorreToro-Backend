<?php

namespace App\Models;

use App\Models\Traits\BelongsToDomain;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use BelongsToDomain;

    protected $fillable = [
        'domain_id',
        'title',
        'slug',
        'subtitle',
        'hero_badge',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'content',
        'sections',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    protected $casts = [
        'sections' => 'array',
        'is_published' => 'boolean',
    ];
}
