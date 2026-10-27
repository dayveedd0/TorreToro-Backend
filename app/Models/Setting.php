<?php

namespace App\Models;

use App\Models\Traits\BelongsToDomain;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use BelongsToDomain;

    protected $fillable = [
        'domain_id',
        'group',
        'key',
        'value',
        'type',
    ];

    public static function get(string $key, mixed $default = null, ?Domain $domain = null): mixed
    {
        $setting = static::forDomain($domain)->where('key', $key)->first();
        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'json' => json_decode($setting->value, true),
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            default => $setting->value,
        };
    }
}
