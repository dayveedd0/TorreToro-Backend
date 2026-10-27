<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $domain = app(Domain::class);

        $query = Post::forDomain($domain)
            ->with('category')
            ->where('is_published', true)
            ->latest('published_at');

        if ($categorySlug = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $posts = $query->paginate($request->integer('per_page', 9));
        $categories = PostCategory::withCount('posts')->get();

        return response()->json([
            'data' => $posts->items(),
            'categories' => $categories,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'total' => $posts->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $domain = app(Domain::class);

        $post = Post::forDomain($domain)
            ->with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (! $post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $recentPosts = Post::forDomain($domain)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return response()->json([
            'data' => $post,
            'recent_posts' => $recentPosts,
        ]);
    }
}
