@extends('admin.layout')

@section('title', 'Domain & Contact Settings')

@section('content')
<div class="max-w-4xl space-y-6" x-data="{
    logoDark: '{{ $settings['site_logo']->value ?? '/storage/uploads/branding/logo.png' }}',
    logoWhite: '{{ $settings['site_logo_white']->value ?? '/storage/uploads/branding/logo-white.png' }}',
    logoSymbol: '{{ $settings['site_symbol']->value ?? '/storage/uploads/branding/logo-symbol.png' }}',
    logoFavicon: '{{ $settings['site_favicon']->value ?? '/storage/uploads/branding/favicon.png' }}',
    brandVideo: '{{ $settings['site_video']->value ?? '/storage/uploads/branding/corporate-logo.mp4' }}'
}">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Domain & Brand Configuration</h1>
            <p class="text-xs text-stone-500 mt-1">Configure localized logos, contact numbers, office address, and social links for <strong class="text-brand-900">{{ $domain->name }}</strong>.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-8">
        @csrf

        <!-- Brand Identity & Assets -->
        <div>
            <h3 class="text-sm font-bold font-serif text-stone-900 uppercase tracking-wider pb-2 border-b border-stone-100 mb-4 flex items-center justify-between">
                <span>Brand Identity & Graphic Assets</span>
                <span class="text-xs font-mono font-normal text-stone-400">Torre Tórò Identity Assets</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Main Linear Logo -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider">Primary Logo (Dark Backgrounds)</label>
                        <button type="button" @click="window.openMediaPicker(url => logoWhite = url, 'branding')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2 py-0.5 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                            <span>Library</span>
                        </button>
                    </div>
                    <div class="flex items-center space-x-3 bg-stone-900 p-2.5 rounded mb-2">
                        <img :src="logoWhite" class="h-8 max-w-full object-contain" alt="White Logo">
                    </div>
                    <input type="text" name="site_logo_white" x-model="logoWhite" class="w-full px-2.5 py-1.5 border border-stone-300 rounded text-xs bg-white">
                </div>

                <!-- Main Dark Logo -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider">Primary Logo (Light Backgrounds)</label>
                        <button type="button" @click="window.openMediaPicker(url => logoDark = url, 'branding')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2 py-0.5 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                            <span>Library</span>
                        </button>
                    </div>
                    <div class="flex items-center space-x-3 bg-stone-100 p-2.5 rounded mb-2 border border-stone-200">
                        <img :src="logoDark" class="h-8 max-w-full object-contain" alt="Dark Logo">
                    </div>
                    <input type="text" name="site_logo" x-model="logoDark" class="w-full px-2.5 py-1.5 border border-stone-300 rounded text-xs bg-white">
                </div>

                <!-- Symbol / Crest -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider">Brand Symbol / Crest</label>
                        <button type="button" @click="window.openMediaPicker(url => logoSymbol = url, 'branding')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2 py-0.5 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                            <span>Library</span>
                        </button>
                    </div>
                    <div class="flex items-center justify-center bg-white p-2.5 rounded mb-2 border border-stone-200">
                        <img :src="logoSymbol" class="h-10 w-10 object-contain" alt="Symbol">
                    </div>
                    <input type="text" name="site_symbol" x-model="logoSymbol" class="w-full px-2.5 py-1.5 border border-stone-300 rounded text-xs bg-white">
                </div>

                <!-- Favicon & Video Asset -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider">Browser Favicon & Brand Video</label>
                        <button type="button" @click="window.openMediaPicker(url => logoFavicon = url, 'branding')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2 py-0.5 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                            <span>Favicon</span>
                        </button>
                    </div>
                    <div class="flex items-center space-x-3 mb-2">
                        <img :src="logoFavicon" class="w-8 h-8 rounded bg-stone-900 p-1 object-contain" alt="Favicon">
                        <input type="text" name="site_favicon" x-model="logoFavicon" class="flex-1 px-2.5 py-1.5 border border-stone-300 rounded text-xs bg-white">
                    </div>
                    <div class="flex items-center justify-between mb-1 mt-3">
                        <span class="text-[11px] font-semibold text-stone-700">Corporate Brand Video:</span>
                        <button type="button" @click="window.openMediaPicker(url => brandVideo = url, 'video')" class="text-[10px] bg-stone-800 text-stone-200 px-2 py-0.5 rounded">Library</button>
                    </div>
                    <input type="text" name="site_video" x-model="brandVideo" class="w-full px-2.5 py-1.5 border border-stone-300 rounded text-xs bg-white">
                </div>
            </div>
        </div>

        <!-- Contact Information Block -->
        <div>
            <h3 class="text-sm font-bold font-serif text-stone-900 uppercase tracking-wider pb-2 border-b border-stone-100 mb-4 flex items-center justify-between">
                <span>Official Contact & Business Phone Lines</span>
                <span class="text-xs font-mono font-normal text-stone-400">Live Business Contact Channels</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Primary Business Phone -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <label class="block text-xs font-bold text-stone-900 uppercase tracking-wider mb-1">
                        Primary Business Phone *
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $domain->phone) }}" required placeholder="+234 813 600 1221"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm font-semibold text-stone-900 focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
                    <p class="text-[11px] text-stone-500 mt-1">Main corporate phone line shown in website headers, footers, and contact hubs.</p>
                </div>

                <!-- Secondary Business Phone -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <label class="block text-xs font-bold text-stone-900 uppercase tracking-wider mb-1">
                        Secondary Business Phone
                    </label>
                    <input type="text" name="secondary_phone" value="{{ old('secondary_phone', $settings['secondary_phone']->value ?? ($settings['contact_phone_secondary']->value ?? '+234 011 336 54')) }}" placeholder="+234 011 336 54"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm font-semibold text-stone-900 focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
                    <p class="text-[11px] text-stone-500 mt-1">Alternative office telephone line for direct client support.</p>
                </div>

                <!-- Header Call Button Phone -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <label class="block text-xs font-bold text-stone-900 uppercase tracking-wider mb-1">
                        Header Call Button Target Phone
                    </label>
                    <input type="text" name="header_phone" value="{{ old('header_phone', $settings['header_phone']->value ?? $domain->phone) }}" placeholder="+234 813 600 1221"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
                    <p class="text-[11px] text-stone-500 mt-1">Dialed directly when visitors click "{{ $settings['header_cta_label']->value ?? 'Call Us Today' }}" in the top bar.</p>
                </div>

                <!-- Header CTA Label -->
                <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <label class="block text-xs font-bold text-stone-900 uppercase tracking-wider mb-1">
                        Header Call-To-Action Label
                    </label>
                    <input type="text" name="header_cta_label" value="{{ old('header_cta_label', $settings['header_cta_label']->value ?? 'Call Us Today') }}"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
                    <p class="text-[11px] text-stone-500 mt-1">Button text beside phone number in header navigation.</p>
                </div>

                <!-- Official Primary Email -->
                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Official Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', $domain->email) }}" required placeholder="hello@torretoro.com"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                    <p class="text-[11px] text-stone-400 mt-1">Primary corporate email inbox.</p>
                </div>

                <!-- Secondary Email -->
                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Secondary / Direct Email</label>
                    <input type="email" name="secondary_email" value="{{ old('secondary_email', $settings['secondary_email']->value ?? ($settings['contact_email_secondary']->value ?? 'dami@torretoro.com')) }}" placeholder="dami@torretoro.com"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                    <p class="text-[11px] text-stone-400 mt-1">Direct management or design consultation email.</p>
                </div>

                <!-- Operating Hours -->
                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Studio Operating Hours</label>
                    <input type="text" name="office_hours" value="{{ old('office_hours', $settings['office_hours']->value ?? 'Monday - Friday: 8:00 AM - 6:00 PM') }}" placeholder="Monday - Friday: 8:00 AM - 6:00 PM"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <!-- Currency Code -->
                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Currency Code</label>
                    <input type="text" name="currency" value="{{ old('currency', $domain->currency) }}" placeholder="NGN or GBP"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono">
                </div>

                <!-- Physical Office Address -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Physical Office Address *</label>
                    <textarea name="address" rows="2" required placeholder="16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA"
                              class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">{{ old('address', $domain->address) }}</textarea>
                </div>

                <div class="md:col-span-2 pt-2">
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Google Maps Embed URL / Iframe Src</label>
                    <input type="text" name="google_maps_embed" value="{{ old('google_maps_embed', $settings['google_maps_embed']->value ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.727768913337!2d3.4735!3d6.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf45300000001%3A0x1!2s16a%20Da-Silva%20St%2C%20Lekki%20Phase%20I%2C%20Lekki%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng') }}"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono">
                    <p class="text-[11px] text-stone-400 mt-1">Embed link for the interactive map shown on contact and homepage blocks.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Google Maps Directions URL</label>
                    <input type="text" name="google_maps_directions" value="{{ old('google_maps_directions', $settings['google_maps_directions']->value ?? 'https://maps.google.com/?q=16a+Da+Silva+Street+Lekki+Phase+1+Lekki+Lagos+NIGERIA') }}"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Homepage Statistics Counters -->
        <div>
            <h3 class="text-sm font-bold font-serif text-stone-900 uppercase tracking-wider pb-2 border-b border-stone-100 mb-4">
                Homepage Metrics & Highlights
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Completed Projects Counter</label>
                    <input type="text" name="projects_count" value="{{ old('projects_count', $settings['projects_count']->value ?? '14') }}" placeholder="14"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Years Experience Counter</label>
                    <input type="text" name="experience_years" value="{{ old('experience_years', $settings['experience_years']->value ?? '7+') }}" placeholder="7+"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Stats Card Headline</label>
                    <input type="text" name="stats_headline" value="{{ old('stats_headline', $settings['stats_headline']->value ?? 'We Govern and Manage Place and Privacy policies') }}"
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Social Media Channels -->
        <div>
            <h3 class="text-sm font-bold font-serif text-stone-900 uppercase tracking-wider pb-2 border-b border-stone-100 mb-4">
                Social Media Links
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Instagram URL</label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $domain->social_links['instagram'] ?? '') }}" placeholder="https://instagram.com/..."
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">LinkedIn URL</label>
                    <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $domain->social_links['linkedin'] ?? '') }}" placeholder="https://linkedin.com/..."
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">X (Twitter) URL</label>
                    <input type="url" name="social_twitter" value="{{ old('social_twitter', $domain->social_links['twitter'] ?? '') }}" placeholder="https://x.com/..."
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">YouTube URL</label>
                    <input type="url" name="social_youtube" value="{{ old('social_youtube', $domain->social_links['youtube'] ?? '') }}" placeholder="https://youtube.com/..."
                           class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Footer Copyright Notice</label>
            <input type="text" name="copyright_text" value="{{ old('copyright_text', $settings['copyright_text']->value ?? 'Torre Toro Projects © All rights reserved Copyrights 2025') }}"
                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
            <button type="submit" class="px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm">
                Save Domain & Brand Settings
            </button>
        </div>
    </form>

</div>
@endsection
