<?php

namespace App\Models\Traits;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToDomain
{
    public static function bootBelongsToDomain(): void
    {
        static::creating(function ($model) {
            if (empty($model->domain_id) && app()->bound(Domain::class)) {
                $activeDomain = app(Domain::class);
                if ($activeDomain && ! $model->isSharedContent) {
                    $model->domain_id = $activeDomain->id;
                }
            }
        });
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function scopeForDomain(Builder $query, ?Domain $domain = null): Builder
    {
        $domain = $domain ?: (app()->bound(Domain::class) ? app(Domain::class) : null);

        if (! $domain) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($domain) {
            $q->whereNull('domain_id')
              ->orWhere('domain_id', $domain->id);
        });
    }
}
