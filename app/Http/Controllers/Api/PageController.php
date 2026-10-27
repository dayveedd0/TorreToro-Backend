<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Page;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function show(string $slug): JsonResponse
    {
        $domain = app(Domain::class);

        $page = Page::forDomain($domain)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (! $page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $data = $page->toArray();

        // Attach active domain information for all pages
        $data['domain'] = [
            'code' => $domain->code,
            'name' => $domain->name,
            'phone' => $domain->phone,
            'email' => $domain->email,
            'address' => $domain->address,
            'currency' => $domain->currency,
            'social_links' => $domain->social_links,
        ];

        // If homepage, attach top featured reviews if review block in sections is empty
        if ($slug === 'home') {
            if (empty($data['sections']['review']['quote'])) {
                $featuredReview = Testimonial::forDomain($domain)
                    ->where('is_featured', true)
                    ->latest()
                    ->first();

                if ($featuredReview) {
                    $data['sections']['review'] = array_merge($data['sections']['review'] ?? [], [
                        'badge' => 'TESTIMONIALS',
                        'heading' => 'Our Clients Say',
                        'quote' => $featuredReview->quote,
                        'client_name' => $featuredReview->client_name,
                        'client_role' => $featuredReview->client_role,
                        'client_company' => $featuredReview->company_name,
                        'client_avatar' => $featuredReview->avatar_image,
                        'rating' => $featuredReview->rating,
                    ]);
                }
            }
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
