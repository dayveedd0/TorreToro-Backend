<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesMediaUploads;
use App\Models\Domain;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    use HandlesMediaUploads;

    public function index(): View
    {
        $domain = app(Domain::class);
        $projects = Project::forDomain($domain)->with('category')->orderBy('order')->latest()->get();

        return view('admin.projects.index', compact('projects', 'domain'));
    }

    public function create(): View
    {
        $domain = app(Domain::class);
        $categories = ProjectCategory::all();

        return view('admin.projects.create', compact('domain', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:20',
            'services_rendered' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|string|max:500',
            'thumbnail_image_file' => 'nullable|image|max:15360',
            'banner_image' => 'nullable|string|max:500',
            'banner_image_file' => 'nullable|image|max:15360',
            'gallery_items' => 'nullable|array',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|max:15360',
            'raw_gallery_urls' => 'nullable|string',
            'stats_area' => 'nullable|string|max:100',
            'stats_timeline' => 'nullable|string|max:100',
            'stats_capacity' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'order' => 'integer',
        ]);

        $domain = app(Domain::class);
        $validated['domain_id'] = $domain->id;
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        $validated['thumbnail_image'] = $this->handleMediaField(
            $request,
            'thumbnail_image_file',
            'thumbnail_image'
        );

        $validated['banner_image'] = $this->handleMediaField(
            $request,
            'banner_image_file',
            'banner_image',
            $validated['thumbnail_image']
        );

        $validated['gallery_images'] = $this->processGallery($request);

        $validated['stats'] = array_filter([
            'area' => $request->input('stats_area'),
            'timeline' => $request->input('stats_timeline'),
            'capacity' => $request->input('stats_capacity'),
        ]);

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully with gallery assets.');
    }

    public function edit(Project $project): View
    {
        $domain = app(Domain::class);
        $categories = ProjectCategory::all();

        return view('admin.projects.edit', compact('project', 'domain', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:20',
            'services_rendered' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|string|max:500',
            'thumbnail_image_file' => 'nullable|image|max:15360',
            'banner_image' => 'nullable|string|max:500',
            'banner_image_file' => 'nullable|image|max:15360',
            'gallery_items' => 'nullable|array',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|max:15360',
            'raw_gallery_urls' => 'nullable|string',
            'stats_area' => 'nullable|string|max:100',
            'stats_timeline' => 'nullable|string|max:100',
            'stats_capacity' => 'nullable|string|max:100',
            'is_featured' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['thumbnail_image'] = $this->handleMediaField(
            $request,
            'thumbnail_image_file',
            'thumbnail_image',
            $project->thumbnail_image
        );

        $validated['banner_image'] = $this->handleMediaField(
            $request,
            'banner_image_file',
            'banner_image',
            $project->banner_image ?: $validated['thumbnail_image']
        );

        $validated['gallery_images'] = $this->processGallery($request, $project->gallery_images ?? []);

        $validated['stats'] = array_filter([
            'area' => $request->input('stats_area'),
            'timeline' => $request->input('stats_timeline'),
            'capacity' => $request->input('stats_capacity'),
        ]);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project and gallery updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Process and compile gallery items from repeater cards, file uploads, and raw URLs.
     */
    protected function processGallery(Request $request, array $existingGallery = []): array
    {
        $gallery = [];

        // 1. Process items explicitly provided in the gallery repeater
        if ($request->has('gallery_items') && is_array($request->input('gallery_items'))) {
            foreach ($request->input('gallery_items') as $item) {
                if (is_array($item) && ! empty($item['url'])) {
                    $gallery[] = [
                        'url' => trim($item['url']),
                        'caption' => trim($item['caption'] ?? ''),
                    ];
                } elseif (is_string($item) && trim($item) !== '') {
                    $gallery[] = [
                        'url' => trim($item),
                        'caption' => '',
                    ];
                }
            }
        } elseif (! $request->has('gallery_items') && ! empty($existingGallery)) {
            // Keep existing if form didn't touch it
            $gallery = $existingGallery;
        }

        // 2. Process newly uploaded multiple files
        $uploadedUrls = $this->handleMultipleMediaFiles($request, 'gallery_files', 'uploads/projects');
        foreach ($uploadedUrls as $url) {
            $gallery[] = [
                'url' => $url,
                'caption' => '',
            ];
        }

        // 3. Process any raw textarea URLs if provided
        if ($request->filled('raw_gallery_urls')) {
            $rawLines = preg_split('/[\r\n,]+/', $request->input('raw_gallery_urls'));
            foreach ($rawLines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    $gallery[] = [
                        'url' => $trimmed,
                        'caption' => '',
                    ];
                }
            }
        }

        // Deduplicate by URL while preserving order
        $unique = [];
        $seen = [];
        foreach ($gallery as $item) {
            $url = is_array($item) ? ($item['url'] ?? '') : $item;
            if ($url && ! in_array($url, $seen)) {
                $seen[] = $url;
                $unique[] = is_array($item) ? $item : ['url' => $url, 'caption' => ''];
            }
        }

        return $unique;
    }
}
