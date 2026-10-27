<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $domain = app(Domain::class);

        $services = Service::forDomain($domain)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => $services,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $domain = app(Domain::class);

        $service = Service::forDomain($domain)
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (! $service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        // Other related services for the sidebar/footer recommendation
        $otherServices = Service::forDomain($domain)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->limit(4)
            ->get();

        return response()->json([
            'data' => $service,
            'other_services' => $otherServices,
        ]);
    }
}
