@extends('admin.layout')

@section('title', 'Homepage Visual CMS Editor')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ 
    activeTab: 'hero',
    previewHero: '{{ $sections['hero']['image'] ?? $page->hero_image ?? '/storage/uploads/hero/hero-bg.jpg' }}',
    heroVideoUrl: '{{ $sections['hero']['video_url'] ?? '/storage/uploads/branding/corporate-logo.mp4' }}',
    previewFeature1: '{{ $sections['about']['image_1'] ?? '/storage/uploads/about/about-page.png' }}',
    previewFeature2: '{{ $sections['about']['image_2'] ?? '/storage/uploads/about/about-story.png' }}',
    featureVideoUrl: '{{ $sections['about']['video_url'] ?? '/storage/uploads/branding/corporate-logo.mp4' }}',
    pillar1Image: '{{ $sections['pillars']['cards'][0]['image'] ?? '/storage/uploads/about/brainstorming.png' }}',
    pillar2Image: '{{ $sections['pillars']['cards'][1]['image'] ?? '/storage/uploads/services/commercial-architecture.jpg' }}',
    pillar3Image: '{{ $sections['pillars']['cards'][2]['image'] ?? '/storage/uploads/projects/sanlam-insurance-1.jpg' }}',
    previewReviewAvatar: '{{ $sections['review']['client_avatar'] ?? '/storage/uploads/team/adeboye-damilola.png' }}',
    previewMapImage: '{{ $sections['map']['map_image'] ?? '/storage/uploads/maps/map-location.png' }}',
    previewBottomPoster: '{{ $sections['bottom_video']['poster_image'] ?? '/storage/uploads/video/video-bg.jpg' }}',
    bottomVideoUrl: '{{ $sections['bottom_video']['video_url'] ?? '/storage/uploads/branding/corporate-logo.mp4' }}',
    mapEmbedUrl: '{{ $sections['map']['embed_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.727768913337!2d3.4735!3d6.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf45300000001%3A0x1!2s16a%20Da-Silva%20St%2C%20Lekki%20Phase%20I%2C%20Lekki%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng' }}'
}">
    <!-- Header Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-stone-200">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-600"></span>
                <span class="text-xs uppercase tracking-widest font-bold text-stone-500 font-mono">Visual Content CMS</span>
            </div>
            <h1 class="text-2xl lg:text-3xl font-serif font-bold text-stone-900 mt-1">Homepage Content & Visual Asset Editor</h1>
            <p class="text-xs sm:text-sm text-stone-600 mt-1">
                Customizing visual assets, Google Map entries, client reviews, and all section copy for 
                <span class="font-bold text-brand-800">{{ $domain->name }}</span> ({{ strtoupper($domain->code) }}).
            </p>
        </div>
        <div class="flex items-center space-x-3 mt-4 md:mt-0">
            <a href="/api/v1/pages/home?domain={{ $domain->code }}" target="_blank" class="inline-flex items-center space-x-1.5 px-3 py-2 text-xs font-semibold rounded-lg bg-stone-200 hover:bg-stone-300 text-stone-800 transition">
                <svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                <span>Preview API Response</span>
            </a>
            <button type="submit" form="homepage-editor-form" class="inline-flex items-center space-x-2 px-5 py-2.5 text-xs font-bold rounded-lg bg-brand-800 hover:bg-brand-900 text-white shadow transition transform active:scale-95">
                <svg class="w-4 h-4 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save All Changes</span>
            </button>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex space-x-2 border-b border-stone-200 overflow-x-auto pb-px mb-8">
        <button type="button" @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>1. Hero & Stats</span>
        </button>
        <button type="button" @click="activeTab = 'about'" :class="activeTab === 'about' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>2. About & Guarantee</span>
        </button>
        <button type="button" @click="activeTab = 'pillars'" :class="activeTab === 'pillars' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>3. 3 Pillars Process</span>
        </button>
        <button type="button" @click="activeTab = 'projects'" :class="activeTab === 'projects' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>4. Projects Showcase</span>
        </button>
        <button type="button" @click="activeTab = 'review'" :class="activeTab === 'review' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>5. Client Review Block</span>
        </button>
        <button type="button" @click="activeTab = 'map'" :class="activeTab === 'map' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>6. Map & Office</span>
        </button>
        <button type="button" @click="activeTab = 'video'" :class="activeTab === 'video' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>7. Video Banner</span>
        </button>
        <button type="button" @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'border-brand-800 text-brand-900 bg-white font-bold shadow-sm' : 'border-transparent text-stone-600 hover:text-stone-900 font-medium'" class="px-4 py-2.5 text-xs rounded-t-lg border-b-2 whitespace-nowrap transition flex items-center space-x-2">
            <span>8. SEO Meta</span>
        </button>
    </div>

    <!-- Main Editor Form -->
    <form id="homepage-editor-form" action="{{ route('admin.home_editor.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- TAB 1: HERO & STATS SECTION -->
        <div x-show="activeTab === 'hero'" class="space-y-8" x-cloak>
            <!-- Hero Copy Card -->
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">Hero Main Copy & Visuals</h2>
                        <p class="text-xs text-stone-500">Edit the top masthead headline, badge, and background visual assets.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Hero Block</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Eyebrow Badge / Tagline</label>
                        <input type="text" name="hero_badge" value="{{ old('hero_badge', $sections['hero']['badge'] ?? $page->hero_badge ?? 'COMMERCIAL INTERIOR DESIGN & ARCHITECTURE') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Primary Button CTA Label & Link</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="hero_cta_text" value="{{ old('hero_cta_text', $sections['hero']['cta_text'] ?? "LET'S CREATE YOUR PERFECT SPACE  →") }}" placeholder="Button Label" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                            <input type="text" name="hero_cta_url" value="{{ old('hero_cta_url', $sections['hero']['cta_url'] ?? '/contact-us') }}" placeholder="/contact-us" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Main Headline (H1)</label>
                        <input type="text" name="hero_title" value="{{ old('hero_title', $sections['hero']['title'] ?? $page->hero_title ?? 'Designing Spaces that Inspire Success') }}" class="w-full text-sm font-bold rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Hero Subtitle / Descriptive Copy</label>
                        <textarea name="hero_subtitle" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-3 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">{{ old('hero_subtitle', $sections['hero']['subtitle'] ?? $page->hero_subtitle ?? 'At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.') }}</textarea>
                    </div>
                </div>

                <!-- Hero Background Image & Video Assets -->
                <div class="mt-6 pt-6 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-3">Hero Media Assets</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hero Background Image -->
                        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-stone-800">Hero Background Image</label>
                                <button type="button" @click="window.openMediaPicker(url => previewHero = url, 'image')" class="inline-flex items-center space-x-1 px-2.5 py-1 bg-stone-900 hover:bg-stone-800 text-white text-[11px] font-semibold rounded shadow-xs transition">
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>Choose from Media Library</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-stone-500 mb-3">Select from Media Library, upload high-res image, or enter URL.</p>
                            
                            <div class="flex items-center space-x-4 mb-3">
                                <img :src="previewHero" class="w-24 h-16 object-cover rounded border border-stone-300 shadow-inner bg-stone-200" onerror="this.src='/storage/uploads/hero/hero-bg.jpg'">
                                <div class="flex-1">
                                    <input type="file" name="hero_image_file" @change="previewHero = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-stone-800 file:text-white hover:file:bg-brand-900 cursor-pointer">
                                </div>
                            </div>
                            <input type="text" name="hero_image_url" x-model="previewHero" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-2 text-stone-700">
                            <input type="hidden" name="hero_image_current" value="{{ $sections['hero']['image'] ?? $page->hero_image }}">
                        </div>

                        <!-- Hero Background Video -->
                        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-stone-800">Hero Background Video (Optional)</label>
                                <button type="button" @click="window.openMediaPicker(url => heroVideoUrl = url, 'video')" class="inline-flex items-center space-x-1 px-2.5 py-1 bg-stone-900 hover:bg-stone-800 text-white text-[11px] font-semibold rounded shadow-xs transition">
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <span>Choose from Library</span>
                                </button>
                            </div>
                            <p class="text-[11px] text-stone-500 mb-3">Upload an MP4 reel or choose corporate video from library.</p>
                            
                            <div class="mb-3">
                                <input type="file" name="hero_video_file" accept="video/mp4,video/webm,video/mov" class="text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-stone-800 file:text-white hover:file:bg-brand-900 cursor-pointer">
                            </div>
                            <input type="text" name="hero_video_url" x-model="heroVideoUrl" placeholder="/storage/uploads/branding/corporate-logo.mp4" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-700">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Counters & Expertise Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- 2 Stat Counters -->
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <h2 class="text-base font-bold text-stone-900 font-serif mb-1">Experience Stat Counters</h2>
                    <p class="text-xs text-stone-500 mb-4">Prominently displayed on the hero right corner.</p>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-3 bg-stone-50 rounded-lg border border-stone-200">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Counter 1 Number</label>
                            <input type="text" name="stat_1_number" value="{{ old('stat_1_number', $sections['stats']['counter_1_number'] ?? '14') }}" class="w-full font-bold text-base rounded border border-stone-300 p-2">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mt-2 mb-1">Counter 1 Label</label>
                            <input type="text" name="stat_1_label" value="{{ old('stat_1_label', $sections['stats']['counter_1_label'] ?? 'Completed Projects') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                        </div>

                        <div class="p-3 bg-stone-50 rounded-lg border border-stone-200">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Counter 2 Number</label>
                            <input type="text" name="stat_2_number" value="{{ old('stat_2_number', $sections['stats']['counter_2_number'] ?? '7+') }}" class="w-full font-bold text-base rounded border border-stone-300 p-2">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mt-2 mb-1">Counter 2 Label</label>
                            <input type="text" name="stat_2_label" value="{{ old('stat_2_label', $sections['stats']['counter_2_label'] ?? 'Years of Experience') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Policy / Stats Sub-headline</label>
                        <input type="text" name="stat_headline" value="{{ old('stat_headline', $sections['stats']['headline'] ?? 'We Govern and Manage Place and Privacy policies') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <!-- 3 Expertise Teasers (Bottom Hero Cards) -->
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                    <h2 class="text-base font-bold text-stone-900 font-serif mb-1">3 Core Expertise Cards</h2>
                    <p class="text-xs text-stone-500 mb-4">Floating hero cards highlighting the company's 3 primary practice disciplines.</p>

                    <div class="space-y-4">
                        <!-- Card 1 -->
                        <div class="p-3 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Card 1 Title</label>
                                    <input type="text" name="expertise_1_title" value="{{ old('expertise_1_title', $sections['expertise'][0]['title'] ?? 'Interior Design') }}" class="w-full text-xs font-bold rounded border border-stone-300 p-2">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Icon Type</label>
                                    <input type="text" name="expertise_1_icon" value="{{ old('expertise_1_icon', $sections['expertise'][0]['icon'] ?? 'cube') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                                </div>
                            </div>
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Description</label>
                            <input type="text" name="expertise_1_desc" value="{{ old('expertise_1_desc', $sections['expertise'][0]['desc'] ?? 'We create functional, stylish spaces that inspire employees and impress clients.') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                        </div>

                        <!-- Card 2 -->
                        <div class="p-3 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Card 2 Title</label>
                                    <input type="text" name="expertise_2_title" value="{{ old('expertise_2_title', $sections['expertise'][1]['title'] ?? 'Project Management') }}" class="w-full text-xs font-bold rounded border border-stone-300 p-2">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Icon Type</label>
                                    <input type="text" name="expertise_2_icon" value="{{ old('expertise_2_icon', $sections['expertise'][1]['icon'] ?? 'building') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                                </div>
                            </div>
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Description</label>
                            <input type="text" name="expertise_2_desc" value="{{ old('expertise_2_desc', $sections['expertise'][1]['desc'] ?? 'Our project management team ensures smooth execution') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                        </div>

                        <!-- Card 3 -->
                        <div class="p-3 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Card 3 Title</label>
                                    <input type="text" name="expertise_3_title" value="{{ old('expertise_3_title', $sections['expertise'][2]['title'] ?? 'Procurement & Fit-out') }}" class="w-full text-xs font-bold rounded border border-stone-300 p-2">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Icon Type</label>
                                    <input type="text" name="expertise_3_icon" value="{{ old('expertise_3_icon', $sections['expertise'][2]['icon'] ?? 'truck') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                                </div>
                            </div>
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Description</label>
                            <input type="text" name="expertise_3_desc" value="{{ old('expertise_3_desc', $sections['expertise'][2]['desc'] ?? 'We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.') }}" class="w-full text-xs rounded border border-stone-300 p-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: ABOUT & GUARANTEE SECTION -->
        <div x-show="activeTab === 'about'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">About Section Copy & Composite Visuals</h2>
                        <p class="text-xs text-stone-500">"With our expertise we guarantee success" section on the live homepage.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">About Block</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Eyebrow / Badge Label</label>
                        <input type="text" name="about_badge" value="{{ old('about_badge', $sections['about']['badge'] ?? 'ABOUT US') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Small Tagline (Above Heading)</label>
                        <input type="text" name="about_tag" value="{{ old('about_tag', $sections['about']['tag'] ?? 'Crafting Experiences') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Main Heading</label>
                        <input type="text" name="about_heading" value="{{ old('about_heading', $sections['about']['heading'] ?? 'With our expertise we guarentee success') }}" class="w-full text-xs font-bold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Paragraph 1 (Main Pitch)</label>
                        <textarea name="about_p1" rows="2" class="w-full text-xs rounded-lg border border-stone-300 p-3">{{ old('about_p1', $sections['about']['paragraph_1'] ?? 'We are a leading interior design firm dedicated to crafting commercial spaces that inspire, innovate, and elevate the way people work.') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Paragraph 2 (Methodology & Precision)</label>
                        <textarea name="about_p2" rows="2" class="w-full text-xs rounded-lg border border-stone-300 p-3">{{ old('about_p2', $sections['about']['paragraph_2'] ?? 'With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Paragraph 3 (Turnkey Delivery Promise)</label>
                        <textarea name="about_p3" rows="2" class="w-full text-xs rounded-lg border border-stone-300 p-3">{{ old('about_p3', $sections['about']['paragraph_3'] ?? 'Whether you are reimagining your corporate office, retail environment, or hospitality space, our tailored approach ensures that your vision comes to life.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Call-To-Action Button Label</label>
                        <input type="text" name="about_cta_text" value="{{ old('about_cta_text', $sections['about']['cta_text'] ?? 'LEARN MORE  →') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Call-To-Action URL</label>
                        <input type="text" name="about_cta_url" value="{{ old('about_cta_url', $sections['about']['cta_url'] ?? '/about-us') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <!-- Composite Images & Video Link -->
                <div class="pt-6 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-3">Feature Media Assets</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Image 1 -->
                        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-stone-800">Photo 1 (Exterior / Team)</label>
                                <button type="button" @click="window.openMediaPicker(url => previewFeature1 = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                    Library
                                </button>
                            </div>
                            <img :src="previewFeature1" class="w-full h-28 object-cover rounded mb-2 border border-stone-300" onerror="this.src='/storage/uploads/about/about-page.png'">
                            <input type="file" name="feature_image_1_file" @change="previewFeature1 = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer mb-2">
                            <input type="text" name="feature_image_1_url" x-model="previewFeature1" placeholder="URL" class="w-full text-xs rounded border border-stone-300 p-1.5">
                        </div>

                        <!-- Image 2 -->
                        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-stone-800">Photo 2 (Interior / Story)</label>
                                <button type="button" @click="window.openMediaPicker(url => previewFeature2 = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                    Library
                                </button>
                            </div>
                            <img :src="previewFeature2" class="w-full h-28 object-cover rounded mb-2 border border-stone-300" onerror="this.src='/storage/uploads/about/about-story.png'">
                            <input type="file" name="feature_image_2_file" @change="previewFeature2 = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer mb-2">
                            <input type="text" name="feature_image_2_url" x-model="previewFeature2" placeholder="URL" class="w-full text-xs rounded border border-stone-300 p-1.5">
                        </div>

                        <!-- Video Player Link -->
                        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-stone-800">Video Showcase</label>
                                <button type="button" @click="window.openMediaPicker(url => featureVideoUrl = url, 'video')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                    Library
                                </button>
                            </div>
                            <p class="text-[11px] text-stone-500 mb-2">Upload or select corporate MP4 reel.</p>
                            <input type="file" name="feature_video_file" accept="video/*" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer mb-2">
                            <input type="text" name="feature_video_url" x-model="featureVideoUrl" placeholder="/storage/uploads/branding/corporate-logo.mp4" class="w-full text-xs rounded border border-stone-300 p-1.5">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: 3 PILLARS / WORK PROCESS -->
        <div x-show="activeTab === 'pillars'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">The 3 Pillars of Torre Tórò Process</h2>
                        <p class="text-xs text-stone-500">Research & Analysis &rarr; Industry Development &rarr; Production Launch.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Process Pillars</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Process Section Eyebrow</label>
                        <input type="text" name="pillars_badge" value="{{ old('pillars_badge', $sections['pillars']['badge'] ?? 'OUR PROCESS') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Process Section Heading</label>
                        <input type="text" name="pillars_heading" value="{{ old('pillars_heading', $sections['pillars']['heading'] ?? 'Architectural Rigor From Vision to Delivery') }}" class="w-full text-xs font-bold rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Pillar 1 -->
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-3">
                        <div class="text-xs font-bold text-brand-800 flex items-center justify-between">
                            <span>STEP 01</span>
                            <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 mb-1">Pillar 1 Title</label>
                            <input type="text" name="pillar_1_title" value="{{ old('pillar_1_title', $sections['pillars']['cards'][0]['title'] ?? 'Research & Analysis') }}" class="w-full text-xs font-bold rounded border border-stone-300 p-2">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 mb-1">Description</label>
                            <textarea name="pillar_1_desc" rows="3" class="w-full text-xs rounded border border-stone-300 p-2">{{ old('pillar_1_desc', $sections['pillars']['cards'][0]['desc'] ?? 'Understanding Context, Culture, and Client Needs') }}</textarea>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-bold text-stone-700">Card Background Image</label>
                                <button type="button" @click="window.openMediaPicker(url => pillar1Image = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded">Library</button>
                            </div>
                            <input type="file" name="pillar_1_image_file" @change="pillar1Image = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs mb-1">
                            <input type="text" name="pillar_1_image_url" x-model="pillar1Image" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-1.5">
                        </div>
                    </div>

                    <!-- Pillar 2 -->
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-3">
                        <div class="text-xs font-bold text-brand-800 flex items-center justify-between">
                            <span>STEP 02</span>
                            <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 mb-1">Pillar 2 Title</label>
                            <input type="text" name="pillar_2_title" value="{{ old('pillar_2_title', $sections['pillars']['cards'][1]['title'] ?? 'Industry Development') }}" class="w-full text-xs font-bold rounded border border-stone-300 p-2">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 mb-1">Description</label>
                            <textarea name="pillar_2_desc" rows="3" class="w-full text-xs rounded border border-stone-300 p-2">{{ old('pillar_2_desc', $sections['pillars']['cards'][1]['desc'] ?? 'Design Innovation, Strategy, and Technical Planning') }}</textarea>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-bold text-stone-700">Card Background Image</label>
                                <button type="button" @click="window.openMediaPicker(url => pillar2Image = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded">Library</button>
                            </div>
                            <input type="file" name="pillar_2_image_file" @change="pillar2Image = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs mb-1">
                            <input type="text" name="pillar_2_image_url" x-model="pillar2Image" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-1.5">
                        </div>
                    </div>

                    <!-- Pillar 3 -->
                    <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-3">
                        <div class="text-xs font-bold text-brand-800 flex items-center justify-between">
                            <span>STEP 03</span>
                            <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 mb-1">Pillar 3 Title</label>
                            <input type="text" name="pillar_3_title" value="{{ old('pillar_3_title', $sections['pillars']['cards'][2]['title'] ?? 'Production Launch') }}" class="w-full text-xs font-bold rounded border border-stone-300 p-2">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-stone-700 mb-1">Description</label>
                            <textarea name="pillar_3_desc" rows="3" class="w-full text-xs rounded border border-stone-300 p-2">{{ old('pillar_3_desc', $sections['pillars']['cards'][2]['desc'] ?? 'Execution, Oversight, and Final Delivery') }}</textarea>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-bold text-stone-700">Card Background Image</label>
                                <button type="button" @click="window.openMediaPicker(url => pillar3Image = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded">Library</button>
                            </div>
                            <input type="file" name="pillar_3_image_file" @change="pillar3Image = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs mb-1">
                            <input type="text" name="pillar_3_image_url" x-model="pillar3Image" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-1.5">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: PROJECTS SHOWCASE SECTION -->
        <div x-show="activeTab === 'projects'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">Portfolio / Special Projects Masthead</h2>
                        <p class="text-xs text-stone-500">Edit the intro headline and CTA for the homepage featured projects section.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Projects Section</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Badge</label>
                        <input type="text" name="projects_badge" value="{{ old('projects_badge', $sections['projects_section']['badge'] ?? 'OUR WORKS') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Heading</label>
                        <input type="text" name="projects_heading" value="{{ old('projects_heading', $sections['projects_section']['heading'] ?? 'Our Special Projects') }}" class="w-full text-xs font-bold rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Subheading</label>
                        <input type="text" name="projects_subheading" value="{{ old('projects_subheading', $sections['projects_section']['subheading'] ?? 'A curated selection of our commercial interior design and turnkey architectural completions.') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Button Label</label>
                        <input type="text" name="projects_cta_text" value="{{ old('projects_cta_text', $sections['projects_section']['cta_text'] ?? 'SEE OUR FULL PORTFOLIO  →') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Button URL</label>
                        <input type="text" name="projects_cta_url" value="{{ old('projects_cta_url', $sections['projects_section']['cta_url'] ?? '/portfolio') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <div class="mt-6 p-4 bg-stone-50 rounded-lg border border-stone-200 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-stone-800">Portfolio Projects are managed independently</div>
                        <div class="text-[11px] text-stone-500">To add, edit, or reorder the actual project items shown in this grid, visit the Portfolio Manager.</div>
                    </div>
                    <a href="{{ route('admin.projects.index') }}" class="px-3 py-1.5 text-xs font-semibold rounded bg-stone-800 hover:bg-stone-900 text-white transition">
                        Manage Projects &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- TAB 5: CLIENT REVIEWS BLOCK -->
        <div x-show="activeTab === 'review'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">Featured Homepage Review Block ("What Our Clients Say")</h2>
                        <p class="text-xs text-stone-500">Edit every piece of copy, author details, star rating, and client photo in the homepage review block.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Review Block</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Badge</label>
                        <input type="text" name="review_badge" value="{{ old('review_badge', $sections['review']['badge'] ?? 'TESTIMONIALS') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Heading</label>
                        <input type="text" name="review_heading" value="{{ old('review_heading', $sections['review']['heading'] ?? 'What Our Clients Say') }}" class="w-full text-xs font-bold rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Subheading / Description</label>
                        <input type="text" name="review_subheading" value="{{ old('review_subheading', $sections['review']['subheading'] ?? 'Hear directly from corporate executives and facility directors whose workspaces we have transformed.') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Featured Testimonial Quote</label>
                        <textarea name="review_quote" rows="4" class="w-full text-xs rounded-lg border border-stone-300 p-3 leading-relaxed">{{ old('review_quote', $sections['review']['quote'] ?? 'As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.') }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 bg-stone-50 rounded-xl border border-stone-200">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Client Full Name</label>
                        <input type="text" name="review_client_name" value="{{ old('review_client_name', $sections['review']['client_name'] ?? 'Mrs Jacobo') }}" class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Client Role / Project Details</label>
                        <input type="text" name="review_client_role" value="{{ old('review_client_role', $sections['review']['client_role'] ?? 'Office Interior Design in Abuja, Nigeria.') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Company / Organization</label>
                        <input type="text" name="review_client_company" value="{{ old('review_client_company', $sections['review']['client_company'] ?? 'Jacobo Corporate Offices') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Star Rating (1 - 5)</label>
                        <select name="review_rating" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 bg-white">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ (int)($sections['review']['rating'] ?? 5) === $i ? 'selected' : '' }}>
                                    {{ $i }} Stars ({{ str_repeat('★', $i) }})
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide">Client Photo / Avatar Asset</label>
                            <button type="button" @click="window.openMediaPicker(url => previewReviewAvatar = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                Choose from Library
                            </button>
                        </div>
                        <div class="flex items-center space-x-3">
                            <img :src="previewReviewAvatar" class="w-12 h-12 rounded-full object-cover border border-stone-300 shadow-sm bg-stone-200" onerror="this.src='/storage/uploads/team/adeboye-damilola.png'">
                            <div class="flex-1 space-y-1">
                                <input type="file" name="review_avatar_file" @change="previewReviewAvatar = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs">
                                <input type="text" name="review_avatar_url" x-model="previewReviewAvatar" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-1.5">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between items-center text-xs text-stone-500">
                    <span>Need to manage multiple reviews across the website?</span>
                    <a href="{{ route('admin.testimonials.index') }}" class="font-semibold text-brand-800 hover:underline">
                        Open Reviews & Testimonials Directory &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- TAB 6: MAP & STUDIO LOCATION ENTRY -->
        <div x-show="activeTab === 'map'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">Studio Locations & Interactive Google Maps</h2>
                        <p class="text-xs text-stone-500">Manage the physical office address, phones, emails, and live Google Maps embed for {{ $domain->name }}.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Map & Office</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Badge</label>
                        <input type="text" name="map_badge" value="{{ old('map_badge', $sections['map']['badge'] ?? 'VISIT OUR STUDIOS') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Section Heading</label>
                        <input type="text" name="map_heading" value="{{ old('map_heading', $sections['map']['heading'] ?? 'Global Footprint & Project Hubs') }}" class="w-full text-xs font-bold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Office / Studio Title</label>
                        <input type="text" name="map_office_title" value="{{ old('map_office_title', $sections['map']['office_title'] ?? ($domain->code === 'uk' ? 'Torre Toro London Design Studio' : 'Torre Toro Architecture Headquarters')) }}" class="w-full text-xs font-semibold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Working / Operating Hours</label>
                        <input type="text" name="map_working_hours" value="{{ old('map_working_hours', $sections['map']['working_hours'] ?? 'Monday - Friday: 8:00 AM - 6:00 PM') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Full Physical Street Address</label>
                        <textarea name="map_address" rows="2" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('map_address', $sections['map']['address'] ?? ($domain->code === 'uk' ? '45 Berkeley Square, Mayfair, London W1J 5AS, United Kingdom' : '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Primary Telephone</label>
                        <input type="text" name="map_phone_1" value="{{ old('map_phone_1', $sections['map']['phone_1'] ?? ($domain->code === 'uk' ? '+44 20 7946 0991' : '+234 813 600 1221')) }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Secondary Telephone</label>
                        <input type="text" name="map_phone_2" value="{{ old('map_phone_2', $sections['map']['phone_2'] ?? ($domain->code === 'uk' ? '+44 20 7946 0912' : '+234 011 336 54')) }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Call Us Today Phone (Header & Studio)</label>
                        <input type="text" name="map_call_us_today" value="{{ old('map_call_us_today', $sections['map']['call_us_today'] ?? ($domain->code === 'uk' ? '+44 20 7946 0991' : '+234 813 600 1221')) }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Primary Email Address</label>
                        <input type="email" name="map_email_1" value="{{ old('map_email_1', $sections['map']['email_1'] ?? ($domain->code === 'uk' ? 'uk@torretoro.com' : 'hello@torretoro.com')) }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Secondary / Personal Email</label>
                        <input type="email" name="map_email_2" value="{{ old('map_email_2', $sections['map']['email_2'] ?? ($domain->code === 'uk' ? 'london@torretoro.com' : 'dami@torretoro.com')) }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <!-- Map Image Graphic Asset -->
                    <div class="md:col-span-2 p-3 bg-stone-50 rounded-lg border border-stone-200">
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-stone-800">Map Graphic / Blueprint Asset</label>
                            <button type="button" @click="window.openMediaPicker(url => previewMapImage = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                Choose Map Asset
                            </button>
                        </div>
                        <div class="flex items-center space-x-3">
                            <img :src="previewMapImage" class="w-24 h-16 object-cover rounded border border-stone-300" onerror="this.src='/storage/uploads/maps/map-location.png'">
                            <input type="text" name="map_image_url" x-model="previewMapImage" placeholder="/storage/uploads/maps/map-location.png" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-800">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Google Maps Embed URL (Iframe Src)</label>
                        <input type="text" name="map_embed_url" x-model="mapEmbedUrl" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 font-mono">
                        <p class="text-[11px] text-stone-500 mt-1">Paste the Google Maps embed URL (e.g. from Google Maps &rarr; Share &rarr; Embed a map &rarr; src URL).</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Google Maps "Get Directions" Link (External)</label>
                        <input type="text" name="map_directions_url" value="{{ old('map_directions_url', $sections['map']['directions_url'] ?? 'https://maps.google.com/?q=16a+Da+Silva+Street+Lekki+Phase+1+Lekki+Lagos+NIGERIA') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <!-- Live Map Interactive Preview -->
                <div class="pt-6 border-t border-stone-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Live Interactive Map Preview</h3>
                    <div class="rounded-xl overflow-hidden border border-stone-300 shadow-inner bg-stone-100 h-64 w-full">
                        <iframe :src="mapEmbedUrl" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 7: BOTTOM VIDEO SHOWCASE BANNER -->
        <div x-show="activeTab === 'video'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">Bottom Video Reel & Showcase Banner</h2>
                        <p class="text-xs text-stone-500">The immersive full-width video banner located directly above the footer.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Video Showcase</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Banner Heading</label>
                        <input type="text" name="bottom_video_heading" value="{{ old('bottom_video_heading', $sections['bottom_video']['heading'] ?? 'Experience Architecture in Motion') }}" class="w-full text-xs font-bold rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Banner Subheading</label>
                        <input type="text" name="bottom_video_subheading" value="{{ old('bottom_video_subheading', $sections['bottom_video']['subheading'] ?? 'Take a dynamic tour through our completed commercial headquarters and signature fit-outs.') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Consultation CTA Button Label</label>
                        <input type="text" name="bottom_video_cta_text" value="{{ old('bottom_video_cta_text', $sections['bottom_video']['cta_text'] ?? "LET'S CREATE YOUR PERFECT SPACE  →") }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Consultation CTA Link</label>
                        <input type="text" name="bottom_video_cta_url" value="{{ old('bottom_video_cta_url', $sections['bottom_video']['cta_url'] ?? '/contact-us') }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-stone-50 rounded-xl border border-stone-200">
                    <!-- Video Poster Image -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-stone-800">Video Thumbnail / Poster Image</label>
                            <button type="button" @click="window.openMediaPicker(url => previewBottomPoster = url, 'image')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                Choose from Library
                            </button>
                        </div>
                        <p class="text-[11px] text-stone-500 mb-2">Displayed before the video plays.</p>
                        <img :src="previewBottomPoster" class="w-full h-32 object-cover rounded mb-2 border border-stone-300" onerror="this.src='/storage/uploads/video/video-bg.jpg'">
                        <input type="file" name="bottom_video_poster_file" @change="previewBottomPoster = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs mb-1">
                        <input type="text" name="bottom_video_poster_url" x-model="previewBottomPoster" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-1.5">
                    </div>

                    <!-- Video File or Stream -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-stone-800">Video File (MP4/WebM) or Stream URL</label>
                            <button type="button" @click="window.openMediaPicker(url => bottomVideoUrl = url, 'video')" class="text-[10px] bg-stone-800 hover:bg-stone-700 text-white px-2 py-0.5 rounded font-semibold">
                                Select Video from Library
                            </button>
                        </div>
                        <p class="text-[11px] text-stone-500 mb-2">Select video reel or enter link.</p>
                        <input type="file" name="bottom_video_file" accept="video/mp4,video/webm,video/mov" class="text-xs mb-3">
                        <label class="block text-[11px] font-bold text-stone-600 mb-1">Video Asset URL:</label>
                        <input type="text" name="bottom_video_url" x-model="bottomVideoUrl" placeholder="/storage/uploads/branding/corporate-logo.mp4" class="w-full text-xs rounded border border-stone-300 p-2 text-stone-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 8: SEO META -->
        <div x-show="activeTab === 'seo'" class="space-y-8" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
                    <div>
                        <h2 class="text-base font-bold text-stone-900 font-serif">Search Engine Optimization (SEO) & OpenGraph</h2>
                        <p class="text-xs text-stone-500">Configure title tags and descriptions for Google and social sharing previews.</p>
                    </div>
                    <span class="text-[11px] font-mono uppercase bg-brand-50 text-brand-800 px-2.5 py-1 rounded border border-brand-100 font-semibold">Metadata</span>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Browser / Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? $domain->meta_title) }}" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">{{ old('meta_description', $page->meta_description ?? $domain->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Save Bar -->
        <div class="sticky bottom-4 z-30 bg-stone-900/95 backdrop-blur text-white px-6 py-4 rounded-xl shadow-2xl flex items-center justify-between border border-stone-700 mt-10">
            <div class="flex items-center space-x-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs text-stone-300">
                    Ready to publish updates to <strong class="text-white">{{ $domain->name }}</strong> ({{ strtoupper($domain->code) }}).
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 text-xs font-bold uppercase tracking-wider rounded-lg bg-brand-700 hover:bg-brand-600 text-white shadow-md transition transform active:scale-95">
                    Save All Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
