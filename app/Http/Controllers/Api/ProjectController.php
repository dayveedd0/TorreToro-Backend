<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $domain = app(Domain::class);

        $query = Project::forDomain($domain)
            ->with('category')
            ->orderBy('order')
            ->latest();

        if ($categorySlug = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $projects = $query->paginate($request->integer('per_page', 12));
        $categories = ProjectCategory::withCount('projects')->get();

        return response()->json([
            'data' => $projects->items(),
            'categories' => $categories,
            'pagination' => [
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
                'total' => $projects->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $domain = app(Domain::class);

        $project = Project::forDomain($domain)
            ->with('category')
            ->where('slug', $slug)
            ->first();

        if (! $project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $relatedProjects = Project::forDomain($domain)
            ->where('id', '!=', $project->id)
            ->where('category_id', $project->category_id)
            ->limit(3)
            ->get();

        return response()->json([
            'data' => $project,
            'related_projects' => $relatedProjects,
        ]);
    }
}
