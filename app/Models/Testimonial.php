<?php

namespace App\Models;

use App\Models\Traits\BelongsToDomain;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use BelongsToDomain;

    protected $fillable = [
        'domain_id',
        'client_name',
        'client_role',
        'company_name',
        'quote',
        'avatar_image',
        'rating',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
