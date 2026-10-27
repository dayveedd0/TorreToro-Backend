<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesMediaUploads;
use App\Models\Domain;
use App\Models\Page;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomePageController extends Controller
{
    use HandlesMediaUploads;

    public function edit(): View
    {
        $domain = app(Domain::class);

        // Retrieve or instantiate Home Page
        $page = Page::firstOrCreate(
            ['domain_id' => $domain->id, 'slug' => 'home'],
            [
                'title' => 'Home',
                'hero_badge' => 'Commercial Architecture & Workspace Design',
                'hero_title' => 'Designing Spaces that Inspire Success',
                'hero_subtitle' => 'We create exceptional commercial spaces and workplace interiors that elevate productivity, ignite collaboration, and embody corporate excellence.',
                'hero_image' => 'https://torretoro.com/wp-content/uploads/2023/11/DSC_0137-scaled.jpg',
                'sections' => [],
                'is_published' => true,
            ]
        );

        $sections = $page->sections ?? [];

        // Fetch testimonials for domain in case admin wants to reference them
        $testimonials = Testimonial::forDomain($domain)->get();

        return view('admin.home.editor', compact('domain', 'page', 'sections', 'testimonials'));
    }

    public function update(Request $request): RedirectResponse
    {
        $domain = app(Domain::class);

        $page = Page::firstOrCreate(
            ['domain_id' => $domain->id, 'slug' => 'home'],
            ['title' => 'Home', 'is_published' => true]
        );

        $existingSections = $page->sections ?? [];

        // 1. Process Media Assets (Upload or URL)
        $heroImage = $this->handleMediaField(
            $request,
            'hero_image_file',
            'hero_image_url',
            $request->input('hero_image_current', $page->hero_image)
        );

        $heroVideo = $this->handleMediaField(
            $request,
            'hero_video_file',
            'hero_video_url',
            $existingSections['hero']['video_url'] ?? null,
            'uploads/videos'
        );

        $exp1Icon = $this->handleMediaField(
            $request,
            'expertise_1_icon_file',
            'expertise_1_icon_url',
            $existingSections['expertise'][0]['icon'] ?? null
        );

        $exp2Icon = $this->handleMediaField(
            $request,
            'expertise_2_icon_file',
            'expertise_2_icon_url',
            $existingSections['expertise'][1]['icon'] ?? null
        );

        $exp3Icon = $this->handleMediaField(
            $request,
            'expertise_3_icon_file',
            'expertise_3_icon_url',
            $existingSections['expertise'][2]['icon'] ?? null
        );

        $featureImg1 = $this->handleMediaField(
            $request,
            'feature_image_1_file',
            'feature_image_1_url',
            $existingSections['about']['image_1'] ?? 'https://torretoro.com/wp-content/uploads/2023/11/DSC_0137-scaled.jpg'
        );

        $featureImg2 = $this->handleMediaField(
            $request,
            'feature_image_2_file',
            'feature_image_2_url',
            $existingSections['about']['image_2'] ?? 'https://torretoro.com/wp-content/uploads/2023/11/DSC_0146-scaled.jpg'
        );

        $featureVideo = $this->handleMediaField(
            $request,
            'feature_video_file',
            'feature_video_url',
            $existingSections['about']['video_url'] ?? null,
            'uploads/videos'
        );

        $pillar1Img = $this->handleMediaField(
            $request,
            'pillar_1_image_file',
            'pillar_1_image_url',
            $existingSections['pillars']['cards'][0]['image'] ?? null
        );

        $pillar2Img = $this->handleMediaField(
            $request,
            'pillar_2_image_file',
            'pillar_2_image_url',
            $existingSections['pillars']['cards'][1]['image'] ?? null
        );

        $pillar3Img = $this->handleMediaField(
            $request,
            'pillar_3_image_file',
            'pillar_3_image_url',
            $existingSections['pillars']['cards'][2]['image'] ?? null
        );

        $reviewAvatar = $this->handleMediaField(
            $request,
            'review_avatar_file',
            'review_avatar_url',
            $existingSections['review']['client_avatar'] ?? null
        );

        $bottomVideoPoster = $this->handleMediaField(
            $request,
            'bottom_video_poster_file',
            'bottom_video_poster_url',
            $existingSections['bottom_video']['poster_image'] ?? null
        );

        $bottomVideo = $this->handleMediaField(
            $request,
            'bottom_video_file',
            'bottom_video_url',
            $existingSections['bottom_video']['video_url'] ?? null,
            'uploads/videos'
        );

        // 2. Assemble Structured Sections
        $newSections = [
            'hero' => [
                'badge' => $request->input('hero_badge'),
                'title' => $request->input('hero_title'),
                'subtitle' => $request->input('hero_subtitle'),
                'cta_text' => $request->input('hero_cta_text', 'Discover More'),
                'cta_url' => $request->input('hero_cta_url', '/services'),
                'image' => $heroImage,
                'video_url' => $heroVideo,
            ],
            'stats' => [
                'counter_1_number' => $request->input('stat_1_number', '14'),
                'counter_1_label' => $request->input('stat_1_label', 'Commercial Projects'),
                'counter_2_number' => $request->input('stat_2_number', '7+'),
                'counter_2_label' => $request->input('stat_2_label', 'Years of Excellence'),
                'headline' => $request->input('stat_headline', 'We Govern and Manage Place and Privacy policies'),
            ],
            'expertise' => [
                [
                    'title' => $request->input('expertise_1_title', 'Interior Design'),
                    'desc' => $request->input('expertise_1_desc', 'Human-centric office designs that blend function and luxury.'),
                    'icon' => $exp1Icon,
                ],
                [
                    'title' => $request->input('expertise_2_title', 'Project Management'),
                    'desc' => $request->input('expertise_2_desc', 'Turnkey site coordination from architectural blueprint to handover.'),
                    'icon' => $exp2Icon,
                ],
                [
                    'title' => $request->input('expertise_3_title', 'Procurement & Fit-Out'),
                    'desc' => $request->input('expertise_3_desc', 'Commercial grade furniture sourcing, MEP installation, and acoustic finishes.'),
                    'icon' => $exp3Icon,
                ],
            ],
            'about' => [
                'badge' => $request->input('about_badge', 'ABOUT US'),
                'heading' => $request->input('about_heading', 'With our expertise we guarantee success'),
                'paragraph_1' => $request->input('about_p1'),
                'paragraph_2' => $request->input('about_p2'),
                'paragraph_3' => $request->input('about_p3'),
                'cta_text' => $request->input('about_cta_text', 'Read More About Us'),
                'cta_url' => $request->input('about_cta_url', '/about-us'),
                'image_1' => $featureImg1,
                'image_2' => $featureImg2,
                'video_url' => $featureVideo,
            ],
            'pillars' => [
                'badge' => $request->input('pillars_badge', 'OUR PROCESS'),
                'heading' => $request->input('pillars_heading', 'Architectural Rigor From Vision to Delivery'),
                'cards' => [
                    [
                        'title' => $request->input('pillar_1_title', 'Research & Analysis'),
                        'desc' => $request->input('pillar_1_desc', 'Comprehensive spatial diagnostics and site feasibility.'),
                        'image' => $pillar1Img,
                    ],
                    [
                        'title' => $request->input('pillar_2_title', 'Industry Development'),
                        'desc' => $request->input('pillar_2_desc', 'Precision 3D BIM modeling, spatial layouts, and engineering.'),
                        'image' => $pillar2Img,
                    ],
                    [
                        'title' => $request->input('pillar_3_title', 'Production Launch'),
                        'desc' => $request->input('pillar_3_desc', 'Turnkey fit-out construction and smooth occupancy handover.'),
                        'image' => $pillar3Img,
                    ],
                ],
            ],
            'projects_section' => [
                'badge' => $request->input('projects_badge', 'PORTFOLIO'),
                'heading' => $request->input('projects_heading', 'Our Special Projects'),
                'subheading' => $request->input('projects_subheading', 'A curated selection of our commercial interior design and turnkey architectural completions.'),
                'cta_text' => $request->input('projects_cta_text', 'View All Projects'),
                'cta_url' => $request->input('projects_cta_url', '/portfolio'),
            ],
            'review' => [
                'badge' => $request->input('review_badge', 'TESTIMONIALS'),
                'heading' => $request->input('review_heading', 'Our Clients Say'),
                'subheading' => $request->input('review_subheading', 'Hear directly from corporate executives and facility directors whose workspaces we have transformed.'),
                'quote' => $request->input('review_quote'),
                'client_name' => $request->input('review_client_name'),
                'client_role' => $request->input('review_client_role'),
                'client_company' => $request->input('review_client_company'),
                'client_avatar' => $reviewAvatar,
                'rating' => (int) $request->input('review_rating', 5),
            ],
            'map' => [
                'badge' => $request->input('map_badge', 'VISIT OUR STUDIOS'),
                'heading' => $request->input('map_heading', 'Global Footprint & Project Hubs'),
                'office_title' => $request->input('map_office_title'),
                'address' => $request->input('map_address'),
                'phone_1' => $request->input('map_phone_1'),
                'phone_2' => $request->input('map_phone_2'),
                'call_us_today' => $request->input('map_call_us_today', $request->input('map_phone_1')),
                'email_1' => $request->input('map_email_1'),
                'email_2' => $request->input('map_email_2'),
                'working_hours' => $request->input('map_working_hours', 'Monday - Friday: 8:00 AM - 6:00 PM'),
                'embed_url' => $request->input('map_embed_url'),
                'directions_url' => $request->input('map_directions_url'),
            ],
            'bottom_video' => [
                'heading' => $request->input('bottom_video_heading', 'Experience Architecture in Motion'),
                'subheading' => $request->input('bottom_video_subheading', 'Take a dynamic tour through our completed commercial headquarters.'),
                'poster_image' => $bottomVideoPoster,
                'video_url' => $bottomVideo,
                'cta_text' => $request->input('bottom_video_cta_text', 'Schedule a Project Consultation'),
                'cta_url' => $request->input('bottom_video_cta_url', '/contact-us'),
            ],
        ];

        // 3. Update Page Record
        $page->update([
            'hero_badge' => $request->input('hero_badge'),
            'hero_title' => $request->input('hero_title'),
            'hero_subtitle' => $request->input('hero_subtitle'),
            'hero_image' => $heroImage,
            'sections' => $newSections,
            'meta_title' => $request->input('meta_title', $page->meta_title),
            'meta_description' => $request->input('meta_description', $page->meta_description),
        ]);

        // 4. Optionally update Domain address & contacts if filled in map section
        if ($request->filled('map_address')) {
            $domain->update([
                'address' => $request->input('map_address'),
                'phone' => $request->input('map_phone_1') ?: $domain->phone,
                'email' => $request->input('map_email_1') ?: $domain->email,
            ]);
        }

        return redirect()->route('admin.home_editor.edit')
            ->with('success', 'Homepage content, media assets, review block, and map settings saved successfully for ' . $domain->name . '!');
    }
}
