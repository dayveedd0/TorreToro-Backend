<?php

namespace App\Models;

use App\Models\Traits\BelongsToDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use BelongsToDomain;

    protected $fillable = [
        'domain_id',
        'category_id',
        'title',
        'slug',
        'client_name',
        'location',
        'year',
        'services_rendered',
        'excerpt',
        'description',
        'thumbnail_image',
        'banner_image',
        'gallery_images',
        'stats',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'stats' => 'array',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'gallery_urls',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    /**
     * Get normalized gallery images with url and caption.
     */
    public function getGalleryImagesAttribute($value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $items = is_array($decoded) ? $decoded : [];
        } elseif (is_array($value)) {
            $items = $value;
        } else {
            $items = [];
        }

        $normalized = [];
        foreach ($items as $item) {
            if (is_string($item) && trim($item) !== '') {
                $normalized[] = [
                    'url' => trim($item),
                    'caption' => '',
                ];
            } elseif (is_array($item) && ! empty($item['url'])) {
                $normalized[] = [
                    'url' => trim($item['url']),
                    'caption' => $item['caption'] ?? '',
                ];
            }
        }

        return $normalized;
    }

    /**
     * Get flat list of gallery image URLs.
     */
    public function getGalleryUrlsAttribute(): array
    {
        return array_column($this->gallery_images, 'url');
    }
}
