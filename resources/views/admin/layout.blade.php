<!DOCTYPE html>
<html lang="en" class="h-full bg-stone-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Torre Tórò Control Panel</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/storage/uploads/branding/favicon.png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fdf3f3',
                            100: '#fae4e4',
                            200: '#f6cdcd',
                            300: '#efa9a9',
                            400: '#e37777',
                            500: '#d24d4d',
                            600: '#be3434',
                            700: '#9f2828',
                            800: '#842424',
                            900: '#722121', // Torre Toro signature red
                            950: '#3e0c0c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full flex flex-col font-sans text-stone-800 antialiased">

    <!-- Top Navigation Bar -->
    <header class="bg-stone-900 text-white border-b border-stone-800 sticky top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5">
                    <img src="/storage/uploads/branding/logo-white.png" alt="Torre Tórò" class="h-8 w-auto object-contain" onerror="this.onerror=null; this.src='/storage/uploads/branding/logo-symbol-white.png'">
                    <span class="text-xs bg-brand-900/80 border border-brand-700/60 px-2 py-0.5 rounded text-brand-200 font-mono font-semibold">ADMIN</span>
                </a>
            </div>

            <!-- Domain Switcher & Profile -->
            <div class="flex items-center space-x-4">
                <!-- Domain Switcher -->
                <div class="flex items-center bg-stone-800/90 rounded-lg p-1 border border-stone-700">
                    <span class="text-xs text-stone-400 px-2 font-medium hidden sm:inline">Domain:</span>
                    <div class="flex items-center space-x-1">
                        @foreach(\App\Models\Domain::where('is_active', true)->get() as $d)
                            <a href="{{ route('admin.switch_domain_get', $d->code) }}" 
                               class="px-2.5 py-1 rounded text-xs font-bold transition flex items-center space-x-1 {{ app(\App\Models\Domain::class)->id === $d->id ? 'bg-brand-800 text-white shadow-sm ring-1 ring-brand-500' : 'text-stone-400 hover:text-white hover:bg-stone-700' }}">
                                <span>{{ $d->code === 'uk' ? '🇬🇧' : '🌐' }}</span>
                                <span>{{ $d->name }}</span>
                                <span class="text-[10px] opacity-75 font-mono">({{ strtoupper($d->code) }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Admin User / Logout -->
                <div class="flex items-center space-x-3 border-l border-stone-800 pl-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-medium text-white flex items-center space-x-1.5 justify-end">
                            <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <span class="text-[10px] bg-stone-800 px-1.5 py-0.2 rounded text-stone-300 font-mono">({{ Auth::user()->roleLabel() ?? 'Admin' }})</span>
                        </div>
                        <div class="text-[10px] text-stone-400">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white px-3 py-1.5 rounded border border-stone-700 transition">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <div class="flex-1 flex overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-stone-900 text-stone-300 flex-shrink-0 flex flex-col justify-between border-r border-stone-800">
            <nav class="p-4 space-y-1 overflow-y-auto">
                <div class="text-[11px] font-semibold text-stone-400 uppercase tracking-wider px-3 mb-2">Main Navigation</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>

                <!-- Homepage Visual CMS Direct Link -->
                <a href="{{ route('admin.home_editor.edit') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.home_editor.*') ? 'bg-brand-900 text-white font-semibold ring-1 ring-brand-500' : 'text-stone-300 hover:bg-stone-800 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span class="font-semibold">Homepage CMS</span>
                    </div>
                </a>

                <a href="{{ route('admin.inquiries.index') }}" class="flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Inquiries & Bookings</span>
                    </div>
                    @php
                        $newInquiriesCount = \App\Models\Inquiry::forDomain(app(\App\Models\Domain::class))->where('status', 'new')->count();
                    @endphp
                    @if($newInquiriesCount > 0)
                        <span class="bg-brand-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $newInquiriesCount }}</span>
                    @endif
                </a>

                <div class="text-[11px] font-semibold text-stone-400 uppercase tracking-wider px-3 pt-5 mb-2">Content & Portfolio</div>

                <a href="{{ route('admin.services.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.services.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Services</span>
                </a>

                <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.projects.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Portfolio Projects</span>
                </a>

                <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.posts.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span>News & Insights</span>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>Client Reviews</span>
                </a>

                <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.pages.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>All Pages Content</span>
                </a>

                <div class="text-[11px] font-semibold text-stone-400 uppercase tracking-wider px-3 pt-5 mb-2">Media & System</div>

                <a href="{{ route('admin.media.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.media.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Media & Assets</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Admin Users & Roles</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-brand-900 text-white font-semibold' : 'hover:bg-stone-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Domain & Contacts</span>
                </a>
            </nav>

            <!-- Active Domain Indicator -->
            <div class="p-4 bg-stone-950/70 border-t border-stone-800">
                <div class="text-[11px] text-stone-400">Managing Context:</div>
                <div class="text-xs font-semibold text-brand-300 truncate mt-0.5 flex items-center space-x-1.5">
                    <span>{{ app(\App\Models\Domain::class)->code === 'uk' ? '🇬🇧' : '🌐' }}</span>
                    <span>{{ app(\App\Models\Domain::class)->name }}</span>
                </div>
                <div class="text-[10px] text-stone-400 mt-1 flex items-center space-x-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Active Code: <strong class="text-white">{{ strtoupper(app(\App\Models\Domain::class)->code) }}</strong></span>
                </div>
            </div>
        </aside>

        <!-- Main Content View -->
        <main class="flex-1 overflow-y-auto bg-stone-50 p-6 lg:p-8">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex justify-between items-center shadow-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 flex justify-between items-center shadow-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700">&times;</button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-bold">Please check the submitted form:</span>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700">&times;</button>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Global Media Library Asset Picker Modal -->
    <div x-data="globalMediaPicker()" @open-media-modal.window="openModal($event.detail)" x-cloak>
        <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-stone-900/80 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative w-full max-w-5xl rounded-2xl bg-white shadow-2xl border border-stone-200 overflow-hidden flex flex-col max-h-[85vh]">
                    <!-- Modal Header -->
                    <div class="px-6 py-4 bg-stone-900 text-white flex items-center justify-between border-b border-stone-800">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3 class="text-sm font-bold uppercase tracking-wider font-serif">Torre Tórò Media Library Asset Picker</h3>
                            <template x-if="isMultiple">
                                <span class="bg-amber-400 text-stone-950 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Multi-Select Mode</span>
                            </template>
                        </div>
                        <button type="button" @click="closeModal()" class="text-stone-400 hover:text-white p-1 rounded-lg hover:bg-stone-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Filter Controls & Search -->
                    <div class="px-6 py-3 bg-stone-50 border-b border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <!-- Tabs -->
                        <div class="flex items-center space-x-1.5 overflow-x-auto text-xs font-semibold">
                            <button type="button" @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-stone-900 text-white' : 'bg-white text-stone-600 hover:bg-stone-200 border border-stone-300'" class="px-3 py-1.5 rounded-lg transition">All (<span x-text="items.length"></span>)</button>
                            <button type="button" @click="activeFilter = 'image'" :class="activeFilter === 'image' ? 'bg-stone-900 text-white' : 'bg-white text-stone-600 hover:bg-stone-200 border border-stone-300'" class="px-3 py-1.5 rounded-lg transition">Images</button>
                            <button type="button" @click="activeFilter = 'video'" :class="activeFilter === 'video' ? 'bg-stone-900 text-white' : 'bg-white text-stone-600 hover:bg-stone-200 border border-stone-300'" class="px-3 py-1.5 rounded-lg transition">Videos</button>
                            <button type="button" @click="activeFilter = 'branding'" :class="activeFilter === 'branding' ? 'bg-stone-900 text-white' : 'bg-white text-stone-600 hover:bg-stone-200 border border-stone-300'" class="px-3 py-1.5 rounded-lg transition">Branding</button>
                            <button type="button" @click="activeFilter = 'projects'" :class="activeFilter === 'projects' ? 'bg-stone-900 text-white' : 'bg-white text-stone-600 hover:bg-stone-200 border border-stone-300'" class="px-3 py-1.5 rounded-lg transition">Projects</button>
                            <button type="button" @click="activeFilter = 'team'" :class="activeFilter === 'team' ? 'bg-stone-900 text-white' : 'bg-white text-stone-600 hover:bg-stone-200 border border-stone-300'" class="px-3 py-1.5 rounded-lg transition">Team</button>
                        </div>

                        <!-- Search Input -->
                        <div class="relative w-full sm:w-64">
                            <input type="text" x-model="searchQuery" placeholder="Search filename..." class="w-full text-xs pl-8 pr-3 py-1.5 rounded-lg border border-stone-300 focus:outline-none focus:border-brand-800">
                            <svg class="w-4 h-4 text-stone-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>

                    <!-- Media Asset Grid -->
                    <div class="p-6 overflow-y-auto flex-1 bg-stone-100/50">
                        <div x-show="isLoading" class="py-12 text-center text-stone-500 text-xs">
                            <svg class="animate-spin h-6 w-6 text-brand-800 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Loading assets from storage...
                        </div>

                        <div x-show="!isLoading && filteredItems().length === 0" class="py-12 text-center text-stone-400 text-xs">
                            No media assets found matching the search criteria.
                        </div>

                        <div x-show="!isLoading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                            <template x-for="item in filteredItems()" :key="item.path">
                                <div @click="isMultiple ? toggleSelect(item) : null"
                                     class="group relative bg-white rounded-lg border overflow-hidden shadow-xs hover:shadow-md transition flex flex-col cursor-pointer"
                                     :class="isMultiple && isSelected(item) ? 'border-brand-900 ring-2 ring-brand-900/30 bg-brand-50/20' : 'border-stone-200 hover:border-brand-600'">

                                    <!-- Selection Checkbox Badge for Multi-select -->
                                    <div x-show="isMultiple" class="absolute top-2 left-2 z-20" @click.stop="toggleSelect(item)">
                                        <div class="w-5 h-5 rounded flex items-center justify-center transition shadow-sm border"
                                             :class="isSelected(item) ? 'bg-brand-900 border-brand-900 text-white' : 'bg-white/90 border-stone-300 text-transparent hover:border-brand-900'">
                                            <svg class="w-3.5 h-3.5 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </div>

                                    <div class="aspect-video w-full bg-stone-900 flex items-center justify-center overflow-hidden relative">
                                        <template x-if="item.is_image">
                                            <img :src="item.url" class="w-full h-full object-cover group-hover:scale-105 transition duration-200" :alt="item.name" loading="lazy">
                                        </template>
                                        <template x-if="item.is_video">
                                            <div class="w-full h-full flex flex-col items-center justify-center bg-stone-900 text-white p-2">
                                                <svg class="w-8 h-8 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                <span class="text-[9px] text-stone-400 font-mono mt-1">VIDEO</span>
                                            </div>
                                        </template>

                                        <!-- Hover overlay for single-select mode -->
                                        <div x-show="!isMultiple" class="absolute inset-0 bg-stone-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center p-2">
                                            <button type="button" @click.stop="selectSingle(item)" class="px-3 py-1.5 bg-brand-800 hover:bg-brand-900 text-white text-xs font-bold rounded shadow transition">
                                                Use Asset
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-1 flex flex-col justify-between">
                                        <div class="text-[11px] font-semibold text-stone-800 truncate" :title="item.name" x-text="item.name"></div>
                                        <div class="flex items-center justify-between text-[10px] text-stone-400 mt-1">
                                            <span class="uppercase font-mono font-semibold" x-text="item.extension"></span>
                                            <span x-text="item.folder"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-3 bg-white border-t border-stone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-stone-600">
                        <div class="flex items-center space-x-3">
                            <span x-text="filteredItems().length + ' asset(s) displayed'"></span>
                            <template x-if="isMultiple">
                                <div class="flex items-center space-x-2 border-l border-stone-200 pl-3">
                                    <span class="font-bold text-brand-900" x-text="selectedItems.length + ' selected'"></span>
                                    <button type="button" @click="selectAllVisible()" class="text-xs text-brand-900 font-semibold hover:underline">Select All Visible</button>
                                    <button type="button" @click="clearSelection()" x-show="selectedItems.length > 0" class="text-xs text-rose-600 font-semibold hover:underline">Clear</button>
                                </div>
                            </template>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button type="button" @click="closeModal()" class="px-4 py-2 border border-stone-300 rounded-lg text-stone-700 hover:bg-stone-100 font-semibold transition text-xs">
                                Cancel
                            </button>
                            <template x-if="isMultiple">
                                <button type="button" @click="confirmMultiple()" :disabled="selectedItems.length === 0"
                                        class="px-5 py-2 bg-brand-900 hover:bg-brand-800 disabled:opacity-40 text-white rounded-lg text-xs font-bold shadow transition flex items-center space-x-1.5">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Insert Selected</span>
                                    <span x-show="selectedItems.length > 0" x-text="'(' + selectedItems.length + ')'"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function globalMediaPicker() {
            return {
                isOpen: false,
                isLoading: false,
                isMultiple: false,
                items: [],
                selectedItems: [],
                activeFilter: 'all',
                searchQuery: '',
                currentCallback: null,

                init() {},

                openModal(detail) {
                    this.isOpen = true;
                    this.currentCallback = detail.callback || null;
                    this.isMultiple = !!detail.multiple;
                    this.selectedItems = [];
                    if (detail.type) {
                        this.activeFilter = detail.type;
                    }
                    if (this.items.length === 0) {
                        this.fetchAssets();
                    }
                },

                closeModal() {
                    this.isOpen = false;
                    this.currentCallback = null;
                    this.selectedItems = [];
                },

                fetchAssets() {
                    this.isLoading = true;
                    fetch('{{ route('admin.media.api') }}')
                        .then(res => res.json())
                        .then(res => {
                            this.items = res.data || [];
                            this.isLoading = false;
                        })
                        .catch(err => {
                            console.error('Error fetching media:', err);
                            this.isLoading = false;
                        });
                },

                filteredItems() {
                    let result = this.items;
                    if (this.activeFilter === 'image') {
                        result = result.filter(i => i.is_image);
                    } else if (this.activeFilter === 'video') {
                        result = result.filter(i => i.is_video);
                    } else if (this.activeFilter === 'branding') {
                        result = result.filter(i => i.folder.toLowerCase() === 'branding');
                    } else if (this.activeFilter === 'projects') {
                        result = result.filter(i => i.folder.toLowerCase() === 'projects');
                    } else if (this.activeFilter === 'team') {
                        result = result.filter(i => i.folder.toLowerCase() === 'team');
                    }

                    if (this.searchQuery.trim() !== '') {
                        const q = this.searchQuery.toLowerCase();
                        result = result.filter(i => i.name.toLowerCase().includes(q) || i.folder.toLowerCase().includes(q));
                    }

                    return result;
                },

                isSelected(item) {
                    return this.selectedItems.some(i => i.url === item.url);
                },

                toggleSelect(item) {
                    const idx = this.selectedItems.findIndex(i => i.url === item.url);
                    if (idx > -1) {
                        this.selectedItems.splice(idx, 1);
                    } else {
                        this.selectedItems.push(item);
                    }
                },

                selectAllVisible() {
                    this.filteredItems().forEach(item => {
                        if (!this.isSelected(item)) {
                            this.selectedItems.push(item);
                        }
                    });
                },

                clearSelection() {
                    this.selectedItems = [];
                },

                selectSingle(item) {
                    if (typeof this.currentCallback === 'function') {
                        this.currentCallback(item.url, item);
                    }
                    this.closeModal();
                },

                confirmMultiple() {
                    if (typeof this.currentCallback === 'function') {
                        const urls = this.selectedItems.map(i => i.url);
                        this.currentCallback(urls, this.selectedItems);
                    }
                    this.closeModal();
                }
            };
        }

        window.openMediaPicker = function(callback, typeFilter = 'all', multiple = false) {
            window.dispatchEvent(new CustomEvent('open-media-modal', {
                detail: { callback: callback, type: typeFilter, multiple: multiple }
            }));
        };
    </script>

</body>
</html>
