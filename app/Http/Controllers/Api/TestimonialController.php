<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $domain = app(Domain::class);

        $testimonials = Testimonial::forDomain($domain)
            ->where('is_featured', true)
            ->latest()
            ->get();

        return response()->json([
            'data' => $testimonials,
        ]);
    }
}
