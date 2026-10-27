<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesMediaUploads;
use App\Models\Domain;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    use HandlesMediaUploads;

    public function index(): View
    {
        $domain = app(Domain::class);
        $pages = Page::forDomain($domain)->get();

        return view('admin.pages.index', compact('pages', 'domain'));
    }

    public function edit(Page $page): View
    {
        $domain = app(Domain::class);
        $sections = $page->sections ?? [];

        return view('admin.pages.edit', compact('page', 'domain', 'sections'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $domain = app(Domain::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_published' => 'nullable|boolean',
        ]);

        $heroImage = $this->handleMediaField(
            $request,
            'hero_image_file',
            'hero_image',
            $page->hero_image
        );

        $sections = $page->sections ?? [];

        // Always keep hero section in sync
        $sections['hero'] = [
            'badge' => $request->input('hero_badge', $page->hero_badge),
            'title' => $request->input('hero_title', $page->hero_title),
            'subtitle' => $request->input('hero_subtitle', $page->hero_subtitle),
            'image' => $heroImage,
        ];

        // Specific page-by-page section handling
        switch ($page->slug) {
            case 'about-us':
                $storyImage = $this->handleMediaField(
                    $request,
                    'story_image_file',
                    'story_image',
                    $sections['story']['image'] ?? '/storage/uploads/about/about-story.png'
                );

                $sections['story'] = [
                    'badge' => $request->input('story_badge', 'OUR STORY'),
                    'heading' => $request->input('story_heading', 'Architectural Passion and Purpose'),
                    'paragraph_1' => $request->input('story_p1'),
                    'paragraph_2' => $request->input('story_p2'),
                    'paragraph_3' => $request->input('story_p3'),
                    'image' => $storyImage,
                ];

                // Core values parsing
                $rawValues = $request->input('values_list', '');
                $valuesArray = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $rawValues))));

                $sections['vision_mission'] = [
                    'vision' => $request->input('vision'),
                    'mission' => $request->input('mission'),
                    'values' => ! empty($valuesArray) ? $valuesArray : ($sections['vision_mission']['values'] ?? ['Creativity', 'Collaboration', 'Excellence', 'Integrity', 'Innovation']),
                ];

                // Team members array
                if ($request->has('team_members')) {
                    $rawMembers = $request->input('team_members', []);
                    $processedMembers = [];

                    foreach ($rawMembers as $index => $member) {
                        if (empty($member['name'])) {
                            continue;
                        }

                        $memberImg = $member['image'] ?? '/storage/uploads/team/adeboye-damilola.png';
                        if ($request->hasFile("team_member_image_{$index}")) {
                            $memberImg = $this->handleMediaField($request, "team_member_image_{$index}", "noop", $memberImg);
                        }

                        $processedMembers[] = [
                            'name' => $member['name'],
                            'role' => $member['role'] ?? '',
                            'bio' => $member['bio'] ?? '',
                            'image' => $memberImg,
                        ];
                    }

                    $sections['team'] = [
                        'badge' => $request->input('team_badge', 'LEADERSHIP'),
                        'heading' => $request->input('team_heading', 'Meet the Team'),
                        'members' => $processedMembers,
                    ];
                }
                break;

            case 'contact-us':
                $mapImage = $this->handleMediaField(
                    $request,
                    'map_image_file',
                    'map_image',
                    $sections['map']['map_image'] ?? ($sections['form_info']['map_image'] ?? '/storage/uploads/maps/map-location.png')
                );

                $sections['form_info'] = [
                    'button_text' => $request->input('form_button_text', 'APPOINTMENT →'),
                    'address' => $request->input('address', $domain->address),
                    'phone_1' => $request->input('phone_1', $domain->phone),
                    'phone_2' => $request->input('phone_2', '+234 011 336 54'),
                    'email_1' => $request->input('email_1', $domain->email),
                    'email_2' => $request->input('email_2', 'dami@torretoro.com'),
                    'working_hours' => $request->input('working_hours', 'Monday - Friday: 8:00 AM - 6:00 PM'),
                    'map_image' => $mapImage,
                    'embed_url' => $request->input('map_embed_url'),
                    'directions_url' => $request->input('map_directions_url'),
                ];

                $sections['map'] = [
                    'map_image' => $mapImage,
                    'embed_url' => $request->input('map_embed_url'),
                    'directions_url' => $request->input('map_directions_url'),
                ];
                break;

            case 'services':
            case 'portfolio':
                $introImage = $this->handleMediaField(
                    $request,
                    'intro_image_file',
                    'intro_image',
                    $sections['intro']['image'] ?? null
                );

                $sections['intro'] = [
                    'heading' => $request->input('intro_heading'),
                    'description' => $request->input('intro_description'),
                    'image' => $introImage,
                ];
                break;

            default:
                if ($request->has('custom_sections') && is_array($request->input('custom_sections'))) {
                    $sections = array_merge($sections, $request->input('custom_sections'));
                }
                break;
        }

        $page->update([
            'title' => $request->input('title'),
            'hero_badge' => $request->input('hero_badge'),
            'hero_title' => $request->input('hero_title'),
            'hero_subtitle' => $request->input('hero_subtitle'),
            'hero_image' => $heroImage,
            'content' => $request->input('content'),
            'sections' => $sections,
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.pages.edit', $page)->with('success', "Page content and visual assets for '{$page->title}' updated successfully.");
    }
}
