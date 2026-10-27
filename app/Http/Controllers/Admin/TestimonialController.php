<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesMediaUploads;
use App\Models\Domain;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    use HandlesMediaUploads;

    public function index(): View
    {
        $domain = app(Domain::class);
        $testimonials = Testimonial::forDomain($domain)->latest()->get();

        return view('admin.testimonials.index', compact('testimonials', 'domain'));
    }

    public function create(): View
    {
        $domain = app(Domain::class);
        return view('admin.testimonials.create', compact('domain'));
    }

    public function store(Request $request): RedirectResponse
    {
        $domain = app(Domain::class);

        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_role' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar_file' => 'nullable|image|max:10240',
            'avatar_url' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
        ]);

        $avatarUrl = $this->handleMediaField(
            $request,
            'avatar_file',
            'avatar_url'
        );

        Testimonial::create([
            'domain_id' => $domain->id,
            'client_name' => $validated['client_name'],
            'client_role' => $validated['client_role'],
            'company_name' => $validated['company_name'],
            'quote' => $validated['quote'],
            'avatar_image' => $avatarUrl,
            'rating' => $validated['rating'],
            'is_featured' => $request->boolean('is_featured', true),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Client review added successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        $domain = app(Domain::class);
        return view('admin.testimonials.edit', compact('testimonial', 'domain'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_role' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar_file' => 'nullable|image|max:10240',
            'avatar_url' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
        ]);

        $avatarUrl = $this->handleMediaField(
            $request,
            'avatar_file',
            'avatar_url',
            $testimonial->avatar_image
        );

        $testimonial->update([
            'client_name' => $validated['client_name'],
            'client_role' => $validated['client_role'],
            'company_name' => $validated['company_name'],
            'quote' => $validated['quote'],
            'avatar_image' => $avatarUrl,
            'rating' => $validated['rating'],
            'is_featured' => $request->boolean('is_featured', false),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Client review updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteLocalMedia($testimonial->avatar_image);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Client review deleted successfully.');
    }
}
