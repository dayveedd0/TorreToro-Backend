<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesMediaUploads;
use App\Models\Domain;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use HandlesMediaUploads;
    public function index(): View
    {
        $domain = app(Domain::class);
        $services = Service::forDomain($domain)->orderBy('order')->get();

        return view('admin.services.index', compact('services', 'domain'));
    }

    public function create(): View
    {
        $domain = app(Domain::class);
        return view('admin.services.create', compact('domain'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'features' => 'nullable|string', // comma or newline separated
            'icon' => 'nullable|string|max:50',
            'thumbnail_image' => 'nullable|string|max:500',
            'thumbnail_image_file' => 'nullable|image|max:15360',
            'order' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $domain = app(Domain::class);
        $validated['domain_id'] = $domain->id;
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);

        $validated['thumbnail_image'] = $this->handleMediaField(
            $request,
            'thumbnail_image_file',
            'thumbnail_image'
        );

        if (! empty($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['features']))));
        } else {
            $validated['features'] = [];
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service): View
    {
        $domain = app(Domain::class);
        return view('admin.services.edit', compact('service', 'domain'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'thumbnail_image' => 'nullable|string|max:500',
            'thumbnail_image_file' => 'nullable|image|max:15360',
            'order' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['thumbnail_image'] = $this->handleMediaField(
            $request,
            'thumbnail_image_file',
            'thumbnail_image',
            $service->thumbnail_image
        );

        if (! empty($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['features']))));
        } else {
            $validated['features'] = [];
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
