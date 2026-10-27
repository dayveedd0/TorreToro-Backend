<?php

namespace App\Models;

use App\Models\Traits\BelongsToDomain;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use BelongsToDomain;

    protected $fillable = [
        'domain_id',
        'type',
        'name',
        'email',
        'phone',
        'company',
        'service_requested',
        'message',
        'preferred_date',
        'status',
    ];
}
