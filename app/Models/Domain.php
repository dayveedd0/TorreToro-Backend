<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    protected $fillable = [
        'code',
        'name',
        'hostnames',
        'currency',
        'phone',
        'email',
        'address',
        'meta_title',
        'meta_description',
        'social_links',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'hostnames' => 'array',
        'social_links' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public static function resolveFromRequest(): self
    {
        // 1. Explicit domain query parameter (e.g., ?domain=uk) or X-Domain header
        $requestedCode = request()->query('domain') ?: request()->header('X-Domain');

        // 2. Active admin session switch (set by admin domain switcher)
        if (! $requestedCode && request()->hasSession() && session()->has('admin_domain_code')) {
            $requestedCode = session('admin_domain_code');
        }

        // 3. Fallback persistent cookie
        if (! $requestedCode && request()->hasCookie('admin_domain_code')) {
            $requestedCode = request()->cookie('admin_domain_code');
        }

        try {
            if ($requestedCode) {
                $domain = static::where('code', strtolower((string) $requestedCode))->where('is_active', true)->first();
                if ($domain) {
                    return $domain;
                }
            }

            $host = request()->getHost();

            // 1. Direct match hostname in hostnames json array
            $domain = static::where('is_active', true)
                ->whereJsonContains('hostnames', $host)
                ->first();

            if ($domain) {
                return $domain;
            }

            // 2. Strip common backend/api subdomain prefixes (e.g. api.torretoro.com -> torretoro.com)
            $cleanHost = preg_replace('/^(api|backend|admin|app|portal|cms|staging|dev)\./i', '', $host);
            if ($cleanHost && $cleanHost !== $host) {
                $subDomainMatch = static::where('is_active', true)
                    ->whereJsonContains('hostnames', $cleanHost)
                    ->first();
                if ($subDomainMatch) {
                    return $subDomainMatch;
                }
            }

            // 3. UK domain indicators
            if (str_contains($host, '.co.uk') || str_starts_with($host, 'uk.') || str_contains($host, '-uk.')) {
                $ukDomain = static::where('code', 'uk')->where('is_active', true)->first();
                if ($ukDomain) {
                    return $ukDomain;
                }
            }

            // Fallback default
            return static::where('is_default', true)->first() 
                ?? static::first() 
                ?? static::createFallbackInstance();
        } catch (\Throwable $e) {
            return static::createFallbackInstance();
        }
    }

    protected static function createFallbackInstance(): self
    {
        return new static([
            'code' => 'global',
            'name' => 'Torre Tórò Global',
            'currency' => 'NGN',
            'phone' => '+234 813 600 1221',
            'email' => 'hello@torretoro.com',
            'address' => '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA',
        ]);
    }
}
