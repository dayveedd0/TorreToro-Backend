@extends('admin.layout')

@section('title', 'Media & Asset Library')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ 
    filter: 'all',
    folderFilter: 'all',
    searchQuery: '',
    copiedText: null,
    copyToClipboard(url) {
        navigator.clipboard.writeText(window.location.origin + url);
        this.copiedText = url;
        setTimeout(() => this.copiedText = null, 2500);
    }
}">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-stone-200">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-700"></span>
                <span class="text-xs uppercase tracking-widest font-bold text-stone-500 font-mono">Digital Asset Management</span>
            </div>
            <h1 class="text-2xl font-serif font-bold text-stone-900 mt-1">Media & Asset Library</h1>
            <p class="text-xs sm:text-sm text-stone-600 mt-1">
                Upload and manage high-resolution architectural photography, reels, blueprints, and branding assets.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-2">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-stone-900 text-white' : 'bg-stone-200 text-stone-700 hover:bg-stone-300'" class="px-3 py-1.5 text-xs font-semibold rounded-lg transition">All Files ({{ count($mediaList) }})</button>
            <button @click="filter = 'images'" :class="filter === 'images' ? 'bg-stone-900 text-white' : 'bg-stone-200 text-stone-700 hover:bg-stone-300'" class="px-3 py-1.5 text-xs font-semibold rounded-lg transition">Images</button>
            <button @click="filter = 'videos'" :class="filter === 'videos' ? 'bg-stone-900 text-white' : 'bg-stone-200 text-stone-700 hover:bg-stone-300'" class="px-3 py-1.5 text-xs font-semibold rounded-lg transition">Videos</button>
        </div>
    </div>

    <!-- Quick Upload Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 mb-8">
        <h2 class="text-sm font-bold text-stone-900 mb-1">Upload New Media Asset</h2>
        <p class="text-xs text-stone-500 mb-4">Supported formats: JPG, PNG, WebP, SVG, GIF, MP4, MOV, WebM (up to 100MB).</p>

        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            <div class="w-full sm:w-48">
                <select name="folder" class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white focus:outline-none focus:border-brand-800">
                    <option value="library">Folder: Library</option>
                    <option value="branding">Folder: Branding</option>
                    <option value="hero">Folder: Hero</option>
                    <option value="about">Folder: About</option>
                    <option value="services">Folder: Services</option>
                    <option value="video">Folder: Video</option>
                    <option value="maps">Folder: Maps</option>
                    <option value="team">Folder: Team</option>
                    <option value="projects">Folder: Projects</option>
                </select>
            </div>
            <input type="file" name="file" required class="w-full sm:flex-1 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-stone-900 file:text-white hover:file:bg-brand-900 cursor-pointer p-2 border border-stone-300 rounded-lg">
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-xs font-bold rounded-lg bg-brand-800 hover:bg-brand-900 text-white shadow transition whitespace-nowrap">
                Upload Asset
            </button>
        </form>
    </div>

    <!-- Folder Filter Bar & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 bg-white p-3 rounded-xl border border-stone-200">
        <div class="flex items-center space-x-1 overflow-x-auto text-xs font-medium">
            <span class="text-stone-400 font-bold uppercase text-[10px] mr-2">Category:</span>
            <button type="button" @click="folderFilter = 'all'" :class="folderFilter === 'all' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">All</button>
            <button type="button" @click="folderFilter = 'Branding'" :class="folderFilter === 'Branding' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Branding</button>
            <button type="button" @click="folderFilter = 'Hero'" :class="folderFilter === 'Hero' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Hero</button>
            <button type="button" @click="folderFilter = 'About'" :class="folderFilter === 'About' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">About</button>
            <button type="button" @click="folderFilter = 'Services'" :class="folderFilter === 'Services' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Services</button>
            <button type="button" @click="folderFilter = 'Video'" :class="folderFilter === 'Video' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Video</button>
            <button type="button" @click="folderFilter = 'Maps'" :class="folderFilter === 'Maps' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Maps</button>
            <button type="button" @click="folderFilter = 'Team'" :class="folderFilter === 'Team' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Team</button>
            <button type="button" @click="folderFilter = 'Projects'" :class="folderFilter === 'Projects' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Projects</button>
            <button type="button" @click="folderFilter = 'Library'" :class="folderFilter === 'Library' ? 'bg-brand-900 text-white' : 'text-stone-600 hover:bg-stone-100'" class="px-2.5 py-1 rounded transition">Library</button>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" x-model="searchQuery" placeholder="Filter by name..." class="w-full text-xs pl-8 pr-3 py-1.5 rounded-lg border border-stone-300 focus:outline-none focus:border-brand-800">
            <svg class="w-4 h-4 text-stone-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>

    <!-- Asset Grid -->
    @if($mediaList->isEmpty())
        <div class="bg-white rounded-xl border border-stone-200 p-12 text-center shadow-sm">
            <svg class="w-12 h-12 text-stone-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <h3 class="text-sm font-bold text-stone-800">No media assets uploaded yet</h3>
            <p class="text-xs text-stone-500 mt-1">Use the upload tool above to upload photography or project walk-through reels.</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($mediaList as $item)
                @php
                    $isImg = $item['is_image'] ? 'true' : 'false';
                    $isVid = $item['is_video'] ? 'true' : 'false';
                    $fName = addslashes($item['folder']);
                    $iName = strtolower(addslashes($item['name']));
                @endphp
                <div x-show="(filter === 'all' || (filter === 'images' && {{ $isImg }}) || (filter === 'videos' && {{ $isVid }})) && (folderFilter === 'all' || folderFilter === '{{ $fName }}') && (searchQuery === '' || '{{ $iName }}'.includes(searchQuery.toLowerCase()))" class="bg-white rounded-xl border border-stone-200 overflow-hidden shadow-sm flex flex-col justify-between group hover:border-brand-500 transition">
                    <!-- Media Preview Area -->
                    <div class="h-32 bg-stone-900 flex items-center justify-center relative overflow-hidden">
                        @if($item['is_image'])
                            <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                        @elseif($item['is_video'])
                            <div class="flex flex-col items-center justify-center text-stone-400">
                                <svg class="w-10 h-10 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span class="text-[9px] font-mono font-bold mt-1 uppercase text-stone-400">Video</span>
                            </div>
                        @else
                            <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif

                        <div class="absolute top-1.5 right-1.5 bg-stone-900/80 text-white text-[9px] font-mono px-1.5 py-0.5 rounded">
                            {{ strtoupper($item['extension']) }}
                        </div>

                        <div class="absolute bottom-1.5 left-1.5 bg-stone-900/80 text-amber-300 text-[9px] font-mono px-1.5 py-0.5 rounded">
                            {{ $item['folder'] }}
                        </div>
                    </div>

                    <!-- Meta & Actions -->
                    <div class="p-3">
                        <div class="text-[11px] font-bold text-stone-800 truncate" title="{{ $item['name'] }}">{{ $item['name'] }}</div>
                        <div class="text-[10px] text-stone-400 flex justify-between mt-0.5">
                            <span>{{ $item['size'] }}</span>
                            <span>{{ $item['last_modified'] }}</span>
                        </div>

                        <div class="mt-3 pt-2 border-t border-stone-100 flex items-center justify-between">
                            <button type="button" @click="copyToClipboard('{{ $item['url'] }}')" class="text-[10px] font-bold text-brand-800 hover:text-brand-900 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span x-text="copiedText === '{{ $item['url'] }}' ? 'Copied!' : 'Copy URL'"></span>
                            </button>

                            <form action="{{ route('admin.media.destroy') }}" method="POST" onsubmit="return confirm('Permanently delete this asset?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="path" value="{{ $item['path'] }}">
                                <button type="submit" class="text-stone-400 hover:text-rose-600 text-xs p-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
