<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesMediaUploads;
use App\Models\Domain;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    use HandlesMediaUploads;
    public function index(): View
    {
        $domain = app(Domain::class);
        $posts = Post::forDomain($domain)->with('category')->latest('published_at')->get();

        return view('admin.posts.index', compact('posts', 'domain'));
    }

    public function create(): View
    {
        $domain = app(Domain::class);
        $categories = PostCategory::all();

        return view('admin.posts.create', compact('domain', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:post_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'featured_image_file' => 'nullable|image|max:15360',
            'author_name' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'is_published' => 'boolean',
        ]);

        $domain = app(Domain::class);
        $validated['domain_id'] = $domain->id;
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']);
        $validated['author_name'] = $validated['author_name'] ?: 'Torre Tórò';
        $validated['published_at'] = now();
        $validated['is_published'] = $request->boolean('is_published', true);

        $validated['featured_image'] = $this->handleMediaField(
            $request,
            'featured_image_file',
            'featured_image'
        );

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Article created successfully.');
    }

    public function edit(Post $post): View
    {
        $domain = app(Domain::class);
        $categories = PostCategory::all();

        return view('admin.posts.edit', compact('post', 'domain', 'categories'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:post_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'featured_image_file' => 'nullable|image|max:15360',
            'author_name' => 'nullable|string|max:100',
            'read_time' => 'nullable|string|max:50',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['featured_image'] = $this->handleMediaField(
            $request,
            'featured_image_file',
            'featured_image',
            $post->featured_image
        );

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Article deleted successfully.');
    }
}
