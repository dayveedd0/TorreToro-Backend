@extends('admin.layout')

@section('title', 'Visual Page Editor - ' . $page->title)

@section('content')
<div class="space-y-6" x-data="{
    activeTab: '{{ $page->slug === 'about-us' ? 'story' : ($page->slug === 'contact-us' ? 'contact' : 'hero') }}',
    heroImage: '{{ $page->hero_image ?? '/storage/uploads/hero/hero-bg.jpg' }}',
    storyImage: '{{ $sections['story']['image'] ?? '/storage/uploads/about/about-story.png' }}',
    mapImage: '{{ $sections['map']['map_image'] ?? ($sections['form_info']['map_image'] ?? '/storage/uploads/maps/map-location.png') }}',
    introImage: '{{ $sections['intro']['image'] ?? '/storage/uploads/services/services-bg.jpg' }}',
    teamMembers: {{ json_encode($sections['team']['members'] ?? [
        ['name' => 'Adeboye Damilola', 'role' => 'MD/CEO', 'bio' => '15+ years experience in commercial interior design, turnkey architecture, and workplace masterplanning.', 'image' => '/storage/uploads/team/adeboye-damilola.png'],
        ['name' => 'Kater Titus', 'role' => 'Chief Technology Officer (CTO)', 'bio' => 'Directing digital twin integrations, smart building automation, and architectural technology systems.', 'image' => '/storage/uploads/team/kater-titus.jpg'],
        ['name' => 'Olamide Roberts', 'role' => 'Media & Brand Director', 'bio' => 'Overseeing visual identity, brand communications, and experiential design narratives.', 'image' => '/storage/uploads/team/olamide-roberts.jpg'],
        ['name' => 'Samuel Oludara', 'role' => 'Project Lead & Spatial Architect', 'bio' => 'Leading site engineering, BIM modeling, and architectural coordination across commercial developments.', 'image' => '/storage/uploads/team/oludara-samuel.jpg'],
        ['name' => 'Idris Salau', 'role' => 'Construction & Site Manager', 'bio' => 'Spearheading on-site fit-out execution, contractor oversight, and structural quality compliance.', 'image' => '/storage/uploads/team/idris-salau.jpg']
    ]) }},
    addMember() {
        this.teamMembers.push({
            name: '',
            role: '',
            bio: '',
            image: '/storage/uploads/team/adeboye-damilola.png'
        });
    },
    removeMember(index) {
        if (confirm('Are you sure you want to remove this team member?')) {
            this.teamMembers.splice(index, 1);
        }
    }
}">

    <!-- Top Navigation Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-stone-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.pages.index') }}" class="hover:text-stone-800 transition">&larr; Back to Pages</a>
                <span>/</span>
                <span class="font-mono text-stone-400">{{ $domain->code }}</span>
                <span>/</span>
                <span class="font-semibold text-stone-700">{{ $page->title }}</span>
            </div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight flex items-center space-x-3">
                <span>{{ $page->title }} CMS Editor</span>
                <span class="text-xs font-mono font-normal uppercase px-2.5 py-0.5 rounded-full {{ $page->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                    {{ $page->is_published ? 'Published' : 'Draft' }}
                </span>
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Manage copy, imagery, and interactive content blocks for <strong>{{ $domain->name }}</strong>.
            </p>
        </div>

        <div class="flex items-center space-x-2">
            @if($page->slug === 'home')
                <a href="{{ route('admin.home_editor.edit') }}" class="inline-flex items-center space-x-1.5 px-3 py-2 bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                    <span>Open 8-Section Homepage CMS</span> &rarr;
                </a>
            @endif
        </div>
    </div>

    @if($page->slug === 'home')
        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-900 text-xs flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>The Home page has a specialized comprehensive 8-section Visual CMS Editor for Hero, Metrics, Expertise, Process Pillars, Portfolio, Reviews, Video Tour, and Studios.</span>
            </div>
            <a href="{{ route('admin.home_editor.edit') }}" class="px-3 py-1.5 bg-amber-900 text-white rounded font-semibold text-xs hover:bg-amber-800 transition whitespace-nowrap">
                Launch Homepage Editor &rarr;
            </a>
        </div>
    @endif

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Navigation Tabs -->
        <div class="flex border-b border-stone-200 space-x-2 overflow-x-auto text-xs font-semibold">
            <button type="button" @click="activeTab = 'hero'"
                    :class="activeTab === 'hero' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                    class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Hero Banner</span>
            </button>

            @if($page->slug === 'about-us')
                <button type="button" @click="activeTab = 'story'"
                        :class="activeTab === 'story' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                        class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Our Story</span>
                </button>

                <button type="button" @click="activeTab = 'vision'"
                        :class="activeTab === 'vision' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                        class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Vision, Mission & Values</span>
                </button>

                <button type="button" @click="activeTab = 'team'"
                        :class="activeTab === 'team' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                        class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Leadership & Team (<span x-text="teamMembers.length"></span>)</span>
                </button>
            @endif

            @if($page->slug === 'contact-us')
                <button type="button" @click="activeTab = 'contact'"
                        :class="activeTab === 'contact' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                        class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>Phones & Studio Contacts</span>
                </button>

                <button type="button" @click="activeTab = 'map'"
                        :class="activeTab === 'map' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                        class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Map & Directions</span>
                </button>
            @endif

            @if($page->slug === 'services' || $page->slug === 'portfolio')
                <button type="button" @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                        class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Overview & Banner</span>
                </button>
            @endif

            <button type="button" @click="activeTab = 'seo'"
                    :class="activeTab === 'seo' ? 'border-brand-900 text-brand-900 bg-white' : 'border-transparent text-stone-500 hover:text-stone-800 bg-stone-50'"
                    class="px-4 py-2.5 border-b-2 rounded-t-lg transition flex items-center space-x-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>SEO Metadata & Settings</span>
            </button>
        </div>

        <!-- TAB 1: HERO SECTION (Available on all pages) -->
        <div x-show="activeTab === 'hero'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
            <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold font-serif text-stone-900">Hero Header & Background Asset</h2>
                    <p class="text-xs text-stone-500">Edit the top badge, main H1 headline, descriptive subtitle, and background photograph.</p>
                </div>
                <span class="text-xs font-mono text-stone-400">Header Component</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Page Name / Title *</label>
                    <input type="text" name="title" value="{{ old('title', $page->title) }}" required
                           class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Hero Tagline / Badge</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $page->hero_badge) }}" placeholder="e.g. ABOUT US or COMMERCIAL ARCHITECTURE"
                           class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Hero Primary Heading (H1)</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $page->hero_title) }}" placeholder="e.g. CRAFTING EXPERIENCES"
                           class="w-full text-sm font-semibold rounded-lg border border-stone-300 p-2.5 focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Hero Subheading & Description</label>
                    <textarea name="hero_subtitle" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:ring-1 focus:ring-brand-900 focus:outline-none">{{ old('hero_subtitle', $page->hero_subtitle) }}</textarea>
                </div>

                <!-- Hero Image with Media Library Picker -->
                <div class="md:col-span-2 p-4 bg-stone-50 rounded-xl border border-stone-200">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide">Hero Header Background Image</label>
                            <p class="text-[11px] text-stone-500">High-resolution banner displayed behind the hero text.</p>
                        </div>
                        <button type="button" @click="window.openMediaPicker(url => heroImage = url, 'hero')" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Choose from Media Library</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                        <div class="sm:col-span-1">
                            <img :src="heroImage" class="w-full h-24 object-cover rounded-lg border border-stone-300 shadow-inner bg-stone-200" onerror="this.src='/storage/uploads/hero/hero-bg.jpg'">
                        </div>
                        <div class="sm:col-span-3 space-y-2">
                            <input type="text" name="hero_image" x-model="heroImage" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-800 font-mono bg-white">
                            <div class="flex items-center space-x-2 text-[11px] text-stone-500">
                                <span>Or upload new:</span>
                                <input type="file" name="hero_image_file" accept="image/*" class="text-xs text-stone-600">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($page->slug === 'about-us')
            <!-- TAB 2: OUR STORY (About Us Page) -->
            <div x-show="activeTab === 'story'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
                <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-serif text-stone-900">Our Story & Narrative</h2>
                        <p class="text-xs text-stone-500">The founding history, corporate mission narrative, and feature story graphic from the live site.</p>
                    </div>
                    <span class="text-xs font-mono text-stone-400">Story Section</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Story Badge</label>
                        <input type="text" name="story_badge" value="{{ old('story_badge', $sections['story']['badge'] ?? 'OUR STORY') }}"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Story Heading (H2)</label>
                        <input type="text" name="story_heading" value="{{ old('story_heading', $sections['story']['heading'] ?? 'Architectural Passion and Purpose') }}"
                               class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Paragraph 1 (The Genesis & Vision)</label>
                        <textarea name="story_p1" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('story_p1', $sections['story']['paragraph_1'] ?? 'Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect. Founded by architects and interior design specialists, we believe design is more than aesthetics; it is a catalyst for corporate productivity.') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Paragraph 2 (Global & Localized Presence)</label>
                        <textarea name="story_p2" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('story_p2', $sections['story']['paragraph_2'] ?? 'With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Paragraph 3 (Execution & Delivery)</label>
                        <textarea name="story_p3" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('story_p3', $sections['story']['paragraph_3'] ?? 'Whether you are reimagining your corporate office, retail environment, or hospitality space, our tailored approach ensures that your vision comes to life.') }}</textarea>
                    </div>

                    <!-- Story Feature Image with Media Picker -->
                    <div class="md:col-span-2 p-4 bg-stone-50 rounded-xl border border-stone-200">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide">Story Feature Showcase Image</label>
                                <p class="text-[11px] text-stone-500">Photographic showcase displayed alongside the narrative text.</p>
                            </div>
                            <button type="button" @click="window.openMediaPicker(url => storyImage = url, 'about')" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Choose from Media Library</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                            <div class="sm:col-span-1">
                                <img :src="storyImage" class="w-full h-24 object-cover rounded-lg border border-stone-300 shadow-inner bg-stone-200" onerror="this.src='/storage/uploads/about/about-story.png'">
                            </div>
                            <div class="sm:col-span-3 space-y-2">
                                <input type="text" name="story_image" x-model="storyImage" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-800 font-mono bg-white">
                                <div class="flex items-center space-x-2 text-[11px] text-stone-500">
                                    <span>Or upload new:</span>
                                    <input type="file" name="story_image_file" accept="image/*" class="text-xs text-stone-600">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: VISION, MISSION & VALUES (About Us Page) -->
            <div x-show="activeTab === 'vision'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
                <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-serif text-stone-900">Vision, Mission & Corporate Values</h2>
                        <p class="text-xs text-stone-500">Core statements and corporate culture guiding Torre Tórò projects worldwide.</p>
                    </div>
                    <span class="text-xs font-mono text-stone-400">Values Component</span>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Corporate Vision Statement</label>
                        <textarea name="vision" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('vision', $sections['vision_mission']['vision'] ?? 'To be a global leader in commercial architecture and workplace design, inspiring businesses to achieve their full potential.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Corporate Mission Statement</label>
                        <textarea name="mission" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('mission', $sections['vision_mission']['mission'] ?? 'To create innovative, high-performance work environments through human-centric design, architectural precision, and seamless project delivery.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Core Values (Comma or line separated)</label>
                        <input type="text" name="values_list" value="{{ old('values_list', isset($sections['vision_mission']['values']) ? (is_array($sections['vision_mission']['values']) ? implode(', ', $sections['vision_mission']['values']) : $sections['vision_mission']['values']) : 'Creativity, Collaboration, Excellence, Integrity, Innovation') }}"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                        <p class="text-[11px] text-stone-400 mt-1">Rendered as badge cards on the About Us page.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 4: LEADERSHIP & TEAM ROSTER (About Us Page) -->
            <div x-show="activeTab === 'team'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
                <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-serif text-stone-900">Executive Leadership & Team Roster</h2>
                        <p class="text-xs text-stone-500">Edit bios, roles, and profile portraits for key leadership and architectural leads.</p>
                    </div>
                    <button type="button" @click="addMember()" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        <span>+ Add Team Member</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Team Section Badge</label>
                        <input type="text" name="team_badge" value="{{ old('team_badge', $sections['team']['badge'] ?? 'LEADERSHIP') }}"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Team Section Heading</label>
                        <input type="text" name="team_heading" value="{{ old('team_heading', $sections['team']['heading'] ?? 'Meet the Team') }}"
                               class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <!-- Team Cards Repeater -->
                <div class="space-y-4 pt-2">
                    <template x-for="(member, index) in teamMembers" :key="index">
                        <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-4 relative">
                            <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                                <span class="text-xs font-bold font-mono text-stone-700" x-text="'Team Member #' + (index + 1) + (member.name ? ': ' + member.name : '')"></span>
                                <button type="button" @click="removeMember(index)" class="text-xs text-rose-600 hover:text-rose-800 font-semibold flex items-center space-x-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Remove</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                                <!-- Portrait Column with Media Library Picker -->
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-bold text-stone-600 uppercase">Profile Portrait</label>
                                    <img :src="member.image" class="w-full h-36 object-cover rounded-lg border border-stone-300 bg-stone-200" onerror="this.src='/storage/uploads/team/adeboye-damilola.png'">
                                    <input type="hidden" :name="'team_members[' + index + '][image]'" x-model="member.image">
                                    <button type="button" @click="window.openMediaPicker(url => member.image = url, 'team')" class="w-full py-1 px-2 bg-stone-900 hover:bg-stone-800 text-white rounded text-[11px] font-semibold flex items-center justify-center space-x-1 transition shadow-xs">
                                        <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Change from Media Library</span>
                                    </button>
                                </div>

                                <!-- Details Column -->
                                <div class="md:col-span-2 space-y-3">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[11px] font-bold text-stone-600 uppercase mb-1">Full Name *</label>
                                            <input type="text" :name="'team_members[' + index + '][name]'" x-model="member.name" placeholder="Adeboye Damilola" required
                                                   class="w-full text-xs rounded border border-stone-300 p-2 bg-white">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-stone-600 uppercase mb-1">Corporate Title / Role *</label>
                                            <input type="text" :name="'team_members[' + index + '][role]'" x-model="member.role" placeholder="MD/CEO" required
                                                   class="w-full text-xs rounded border border-stone-300 p-2 bg-white">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-stone-600 uppercase mb-1">Short Professional Bio</label>
                                        <textarea :name="'team_members[' + index + '][bio]'" x-model="member.bio" rows="2" placeholder="Experience and background..."
                                                  class="w-full text-xs rounded border border-stone-300 p-2 bg-white"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        @endif

        @if($page->slug === 'contact-us')
            <!-- TAB 2: PHONES & STUDIO CONTACTS (Contact Us Page) -->
            <div x-show="activeTab === 'contact'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
                <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-serif text-stone-900">Direct Business Phone Lines & Office Information</h2>
                        <p class="text-xs text-stone-500">Configure phone lines, consultation appointment button, emails, and operating hours.</p>
                    </div>
                    <span class="text-xs font-mono text-stone-400">Contact Channels</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Form Appointment Button Text -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Appointment Submit Button Label</label>
                        <input type="text" name="form_button_text" value="{{ old('form_button_text', $sections['form_info']['button_text'] ?? 'APPOINTMENT →') }}" placeholder="APPOINTMENT →"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <!-- Primary Phone -->
                    <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                        <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide mb-1">
                            Primary Business Phone *
                        </label>
                        <input type="text" name="phone_1" value="{{ old('phone_1', $sections['form_info']['phone_1'] ?? $domain->phone) }}" required placeholder="+234 813 600 1221"
                               class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5 bg-white">
                        <p class="text-[11px] text-stone-500 mt-1">Main phone line displayed on contact page cards and appointment headers.</p>
                    </div>

                    <!-- Secondary Phone -->
                    <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                        <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide mb-1">
                            Secondary Business Phone
                        </label>
                        <input type="text" name="phone_2" value="{{ old('phone_2', $sections['form_info']['phone_2'] ?? '+234 011 336 54') }}" placeholder="+234 011 336 54"
                               class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5 bg-white">
                        <p class="text-[11px] text-stone-500 mt-1">Alternative desk telephone line for clients.</p>
                    </div>

                    <!-- Primary Email -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Primary Email Address *</label>
                        <input type="email" name="email_1" value="{{ old('email_1', $sections['form_info']['email_1'] ?? $domain->email) }}" required placeholder="hello@torretoro.com"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <!-- Secondary Email -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Secondary / Direct Email</label>
                        <input type="email" name="email_2" value="{{ old('email_2', $sections['form_info']['email_2'] ?? 'dami@torretoro.com') }}" placeholder="dami@torretoro.com"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <!-- Working Hours -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Office Operating Hours</label>
                        <input type="text" name="working_hours" value="{{ old('working_hours', $sections['form_info']['working_hours'] ?? 'Monday - Friday: 8:00 AM - 6:00 PM') }}"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <!-- Physical Office Address -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Office Physical Address</label>
                        <input type="text" name="address" value="{{ old('address', $sections['form_info']['address'] ?? $domain->address) }}"
                               class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>
            </div>

            <!-- TAB 3: MAP & DIRECTIONS (Contact Us Page) -->
            <div x-show="activeTab === 'map'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
                <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-serif text-stone-900">Interactive Map & Directions</h2>
                        <p class="text-xs text-stone-500">Google Maps embed frame, graphic mockup asset, and directions link.</p>
                    </div>
                    <span class="text-xs font-mono text-stone-400">Map Component</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Google Maps Embed URL</label>
                        <input type="text" name="map_embed_url" value="{{ old('map_embed_url', $sections['map']['embed_url'] ?? ($sections['form_info']['embed_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.727768913337!2d3.4735!3d6.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf45300000001%3A0x1!2s16a%20Da-Silva%20St%2C%20Lekki%20Phase%20I%2C%20Lekki%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng')) }}"
                               class="w-full text-xs font-mono rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Google Maps Directions Link</label>
                        <input type="text" name="map_directions_url" value="{{ old('map_directions_url', $sections['map']['directions_url'] ?? ($sections['form_info']['directions_url'] ?? 'https://maps.google.com/?q=16a+Da+Silva+Street+Lekki+Phase+1+Lekki+Lagos+NIGERIA')) }}"
                               class="w-full text-xs font-mono rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <!-- Map Graphic Asset with Media Library Picker -->
                    <div class="md:col-span-2 p-4 bg-stone-50 rounded-xl border border-stone-200">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide">Map Location Graphic Asset</label>
                                <p class="text-[11px] text-stone-500">Stylized map vector graphic or location pinpoint illustration.</p>
                            </div>
                            <button type="button" @click="window.openMediaPicker(url => mapImage = url, 'maps')" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Choose from Media Library</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                            <div class="sm:col-span-1">
                                <img :src="mapImage" class="w-full h-24 object-cover rounded-lg border border-stone-300 shadow-inner bg-stone-200" onerror="this.src='/storage/uploads/maps/map-location.png'">
                            </div>
                            <div class="sm:col-span-3 space-y-2">
                                <input type="text" name="map_image" x-model="mapImage" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-800 font-mono bg-white">
                                <div class="flex items-center space-x-2 text-[11px] text-stone-500">
                                    <span>Or upload new:</span>
                                    <input type="file" name="map_image_file" accept="image/*" class="text-xs text-stone-600">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($page->slug === 'services' || $page->slug === 'portfolio')
            <!-- TAB 2: OVERVIEW & BANNER (Services & Portfolio Pages) -->
            <div x-show="activeTab === 'overview'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
                <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-serif text-stone-900">{{ $page->title }} Intro & Overview Banner</h2>
                        <p class="text-xs text-stone-500">Section intro and featured showcase image for {{ $page->title }}.</p>
                    </div>
                    @if($page->slug === 'services')
                        <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-brand-900 hover:underline">
                            Manage Individual Services &rarr;
                        </a>
                    @else
                        <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-brand-900 hover:underline">
                            Manage Portfolio Projects &rarr;
                        </a>
                    @endif
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Intro Section Heading</label>
                        <input type="text" name="intro_heading" value="{{ old('intro_heading', $sections['intro']['heading'] ?? ($page->slug === 'services' ? 'Comprehensive Commercial Architecture Solutions' : 'Curated Commercial Portfolio')) }}"
                               class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Intro Detailed Paragraph</label>
                        <textarea name="intro_description" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('intro_description', $sections['intro']['description'] ?? 'From corporate headquarters to specialized creative work studios, we manage design, engineering, and execution seamlessly.') }}</textarea>
                    </div>

                    <!-- Intro Image with Media Library Picker -->
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-200">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide">Featured Intro Graphic / Banner</label>
                                <p class="text-[11px] text-stone-500">Graphic banner featured on the {{ $page->title }} overview.</p>
                            </div>
                            <button type="button" @click="window.openMediaPicker(url => introImage = url, '{{ $page->slug === 'services' ? 'services' : 'projects' }}')" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Choose from Media Library</span>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                            <div class="sm:col-span-1">
                                <img :src="introImage" class="w-full h-24 object-cover rounded-lg border border-stone-300 shadow-inner bg-stone-200" onerror="this.src='/storage/uploads/services/services-bg.jpg'">
                            </div>
                            <div class="sm:col-span-3 space-y-2">
                                <input type="text" name="intro_image" x-model="introImage" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-800 font-mono bg-white">
                                <div class="flex items-center space-x-2 text-[11px] text-stone-500">
                                    <span>Or upload new:</span>
                                    <input type="file" name="intro_image_file" accept="image/*" class="text-xs text-stone-600">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB: SEO METADATA & PUBLISHING (Available on all pages) -->
        <div x-show="activeTab === 'seo'" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
            <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold font-serif text-stone-900">SEO Metadata & Status</h2>
                    <p class="text-xs text-stone-500">Search engine meta tags and publishing state for {{ $page->title }}.</p>
                </div>
                <span class="text-xs font-mono text-stone-400">SEO</span>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" placeholder="e.g. {{ $page->title }} | Torre Tórò Architecture"
                           class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">SEO Meta Description</label>
                    <textarea name="meta_description" rows="3" placeholder="Brief search snippet description..."
                              class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Optional Additional HTML / Markdown Body Copy</label>
                    <textarea name="content" rows="6" placeholder="Custom body narrative or fallback content..."
                              class="w-full text-xs font-mono rounded-lg border border-stone-300 p-2.5">{{ old('content', $page->content) }}</textarea>
                </div>

                <div class="pt-2 flex items-center space-x-3">
                    <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-stone-300 text-brand-900 focus:ring-brand-900">
                    <label for="is_published" class="text-xs font-semibold text-stone-800">
                        Page is Published and Publicly Visible
                    </label>
                </div>
            </div>
        </div>

        <!-- Sticky Floating Save Bar -->
        <div class="sticky bottom-4 z-20 bg-stone-900 text-white p-4 rounded-xl shadow-xl flex items-center justify-between border border-stone-800">
            <div class="flex items-center space-x-3 text-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Editing: <strong>{{ $page->title }}</strong> on <strong class="text-amber-400">{{ $domain->name }}</strong></span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-stone-700 hover:bg-stone-800 text-stone-300 rounded-lg text-xs font-semibold transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-brand-900 hover:bg-brand-800 text-white rounded-lg text-xs font-bold shadow-md transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save All Changes</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
