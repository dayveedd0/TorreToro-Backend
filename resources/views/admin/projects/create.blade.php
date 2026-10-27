@extends('admin.layout')

@section('title', 'Add Project')

@section('content')
<div class="max-w-5xl space-y-6" x-data="{
    previewImg: '{{ old('thumbnail_image', '') }}',
    bannerImg: '{{ old('banner_image', '') }}',
    gallery: {{ json_encode(old('gallery_items', [])) }},
    showBulkUrl: false,
    addGalleryItems(urls) {
        if (!urls) return;
        if (Array.isArray(urls)) {
            urls.forEach(url => {
                const targetUrl = typeof url === 'object' && url.url ? url.url : url;
                if (targetUrl && !this.gallery.some(g => g.url === targetUrl)) {
                    this.gallery.push({ url: targetUrl, caption: '' });
                }
            });
        } else if (typeof urls === 'string' && !this.gallery.some(g => g.url === urls)) {
            this.gallery.push({ url: urls, caption: '' });
        }
    },
    removeGalleryItem(index) {
        this.gallery.splice(index, 1);
    },
    moveItem(index, direction) {
        const targetIndex = index + direction;
        if (targetIndex < 0 || targetIndex >= this.gallery.length) return;
        const item = this.gallery.splice(index, 1)[0];
        this.gallery.splice(targetIndex, 0, item);
    },
    setAsCover(url) {
        this.previewImg = url;
    }
}">

    <div class="flex items-center justify-between pb-2 border-b border-stone-200">
        <div>
            <div class="flex items-center space-x-2 text-xs text-stone-500 mb-1">
                <a href="{{ route('admin.projects.index') }}" class="hover:text-stone-800 transition">&larr; Back to Projects</a>
                <span>/</span>
                <span class="font-semibold text-stone-700">Add New Project</span>
            </div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Create Commercial Project</h1>
            <p class="text-xs text-stone-500 mt-1">Add architectural specifications, narrative breakdown, cover assets, and a photo gallery.</p>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
        @csrf

        <!-- Basic Project Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Project Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Sanlam Insurance HQ"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">URL Slug (Optional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generated from title"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Project Category</label>
                <select name="category_id" class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Client Name</label>
                <input type="text" name="client_name" value="{{ old('client_name') }}" placeholder="e.g. Sanlam Insurance Group"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Victoria Island, Lagos"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Completion Year</label>
                <input type="text" name="year" value="{{ old('year', date('Y')) }}" placeholder="2024"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Services Rendered Summary</label>
            <input type="text" name="services_rendered" value="{{ old('services_rendered') }}" placeholder="e.g. Commercial Interior Design & Turnkey Fit-Out"
                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Short Excerpt (Grid Card Caption)</label>
            <textarea name="excerpt" rows="2" placeholder="Brief summary of the architectural brief and outcome..."
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Full Project Narrative / Story</label>
            <textarea name="description" rows="5" placeholder="In-depth project breakdown..."
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono text-xs">{{ old('description') }}</textarea>
        </div>

        <!-- Primary Cover & Banner Assets -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Cover / Thumbnail -->
            <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide">Primary Cover / Thumbnail *</label>
                        <p class="text-[11px] text-stone-500">Card image for portfolio archive and home carousel.</p>
                    </div>
                    <button type="button" @click="window.openMediaPicker(url => previewImg = url, 'projects')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2.5 py-1 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Library</span>
                    </button>
                </div>
                <div class="flex items-center space-x-3">
                    <img :src="previewImg" class="w-24 h-16 object-cover rounded border border-stone-300 bg-stone-200" onerror="this.src='/storage/uploads/projects/sanlam-insurance-1.jpg'">
                    <div class="flex-1 space-y-1.5">
                        <input type="file" name="thumbnail_image_file" @change="previewImg = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer">
                        <input type="text" name="thumbnail_image" x-model="previewImg" placeholder="/storage/uploads/projects/..." class="w-full px-2.5 py-1 border border-stone-300 rounded text-xs bg-white font-mono">
                    </div>
                </div>
            </div>

            <!-- Banner Header -->
            <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold text-stone-900 uppercase tracking-wide">Project Page Hero Banner</label>
                        <p class="text-[11px] text-stone-500">Wide banner on project detail page (defaults to cover).</p>
                    </div>
                    <button type="button" @click="window.openMediaPicker(url => bannerImg = url, 'projects')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2.5 py-1 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Library</span>
                    </button>
                </div>
                <div class="flex items-center space-x-3">
                    <img :src="bannerImg || previewImg" class="w-24 h-16 object-cover rounded border border-stone-300 bg-stone-200" onerror="this.src='/storage/uploads/projects/sanlam-insurance-1.jpg'">
                    <div class="flex-1 space-y-1.5">
                        <input type="file" name="banner_image_file" @change="bannerImg = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer">
                        <input type="text" name="banner_image" x-model="bannerImg" placeholder="Leave blank to use cover image" class="w-full px-2.5 py-1 border border-stone-300 rounded text-xs bg-white font-mono">
                    </div>
                </div>
            </div>
        </div>

        <!-- PROJECT IMAGE GALLERY SECTION -->
        <div class="p-5 bg-stone-50 rounded-xl border border-stone-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-stone-200">
                <div>
                    <div class="flex items-center space-x-2">
                        <h3 class="text-sm font-bold font-serif text-stone-900 uppercase tracking-wider">Project Photography Gallery</h3>
                        <span class="text-xs font-mono font-bold bg-brand-900 text-white px-2 py-0.5 rounded-full" x-text="gallery.length + ' photos'"></span>
                    </div>
                    <p class="text-xs text-stone-500 mt-0.5">High-resolution interior shots, boardroom suites, workstations, and detail views shown in the project walkthrough gallery.</p>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Choose from Media Library (Multi-select) -->
                    <button type="button" @click="window.openMediaPicker(urls => addGalleryItems(urls), 'projects', true)" class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Choose Multiple from Library</span>
                    </button>

                    <!-- Toggle Bulk URL -->
                    <button type="button" @click="showBulkUrl = !showBulkUrl" class="px-2.5 py-1.5 border border-stone-300 text-stone-700 bg-white hover:bg-stone-100 rounded-lg text-xs font-semibold transition">
                        <span>Bulk URLs</span>
                    </button>
                </div>
            </div>

            <!-- Batch Upload Input -->
            <div class="p-3 bg-white rounded-lg border border-dashed border-stone-300 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center space-x-3 text-xs text-stone-600">
                    <svg class="w-6 h-6 text-brand-900 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <div>
                        <span class="font-semibold text-stone-900">Upload multiple photos directly:</span>
                        <p class="text-[11px] text-stone-400">Select multiple high-resolution JPEG or PNG images from your computer.</p>
                    </div>
                </div>
                <input type="file" name="gallery_files[]" multiple accept="image/*" class="text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:bg-stone-900 file:text-white cursor-pointer">
            </div>

            <!-- Optional Bulk Textarea -->
            <div x-show="showBulkUrl" x-transition class="p-3 bg-white rounded-lg border border-stone-200 space-y-2">
                <label class="block text-xs font-semibold text-stone-700">Paste Multiple Image URLs (one per line or comma-separated):</label>
                <textarea name="raw_gallery_urls" rows="2" placeholder="/storage/uploads/projects/photo1.jpg&#10;/storage/uploads/projects/photo2.jpg" class="w-full text-xs font-mono border border-stone-300 rounded p-2 focus:ring-1 focus:ring-brand-900 focus:outline-none"></textarea>
            </div>

            <!-- Interactive Gallery Grid -->
            <div>
                <template x-if="gallery.length === 0">
                    <div class="py-8 text-center bg-white rounded-lg border border-dashed border-stone-200">
                        <svg class="w-8 h-8 mx-auto text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-stone-500 font-medium">No gallery images added yet.</p>
                        <p class="text-[11px] text-stone-400 mt-0.5">Click <strong>Choose from Media Library</strong> or choose files above to build the project gallery.</p>
                    </div>
                </template>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    <template x-for="(item, index) in gallery" :key="index">
                        <div class="bg-white rounded-lg border border-stone-200 overflow-hidden shadow-xs flex flex-col justify-between group hover:border-brand-900 transition">
                            <div class="relative">
                                <img :src="item.url" class="w-full h-32 object-cover bg-stone-100" onerror="this.src='/storage/uploads/projects/sanlam-insurance-1.jpg'">
                                <span class="absolute top-1.5 left-1.5 bg-stone-900/80 text-white font-mono text-[10px] px-1.5 py-0.5 rounded" x-text="'#' + (index + 1)"></span>

                                <div class="absolute top-1.5 right-1.5 flex items-center space-x-1">
                                    <button type="button" @click="setAsCover(item.url)" title="Set as project cover" class="bg-white/90 hover:bg-white text-stone-800 text-[10px] font-bold px-1.5 py-0.5 rounded shadow-xs">
                                        Make Cover
                                    </button>
                                    <button type="button" @click="removeGalleryItem(index)" title="Remove from gallery" class="bg-rose-600 hover:bg-rose-700 text-white p-1 rounded shadow-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-2.5 space-y-2 bg-white">
                                <input type="hidden" :name="'gallery_items[' + index + '][url]'" x-model="item.url">
                                <div>
                                    <input type="text" :name="'gallery_items[' + index + '][caption]'" x-model="item.caption" placeholder="Caption (e.g. Executive Boardroom)" class="w-full text-[11px] border border-stone-200 rounded px-2 py-1 text-stone-800 focus:outline-none focus:ring-1 focus:ring-brand-900">
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-stone-400 pt-1 border-t border-stone-100">
                                    <span class="truncate max-w-[120px] font-mono text-[10px]" x-text="item.url"></span>
                                    <div class="flex items-center space-x-1">
                                        <button type="button" @click="moveItem(index, -1)" :disabled="index === 0" class="px-1.5 py-0.5 bg-stone-100 hover:bg-stone-200 disabled:opacity-30 rounded text-stone-700 font-bold">&larr;</button>
                                        <button type="button" @click="moveItem(index, 1)" :disabled="index === gallery.length - 1" class="px-1.5 py-0.5 bg-stone-100 hover:bg-stone-200 disabled:opacity-30 rounded text-stone-700 font-bold">&rarr;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Project Specifications & Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2 bg-stone-50 p-4 rounded-lg border border-stone-200">
            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Area / Size</label>
                <input type="text" name="stats_area" value="{{ old('stats_area') }}" placeholder="e.g. 15,000 sq ft"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Timeline</label>
                <input type="text" name="stats_timeline" value="{{ old('stats_timeline') }}" placeholder="e.g. 16 weeks"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Capacity / Desks</label>
                <input type="text" name="stats_capacity" value="{{ old('stats_capacity') }}" placeholder="e.g. 250 workstations"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none bg-white">
            </div>
        </div>

        <div class="flex items-center space-x-6 pt-2">
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-stone-300 text-brand-900 focus:ring-brand-900">
                <label for="is_featured" class="text-xs font-medium text-stone-700">Feature on Homepage</label>
            </div>
            <div>
                <label class="text-xs font-medium text-stone-700 mr-2">Display Sort Order:</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-16 px-2 py-1 text-xs border border-stone-300 rounded">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 text-xs font-medium rounded-lg hover:bg-stone-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-bold rounded-lg shadow-sm transition">Save Project & Gallery</button>
        </div>
    </form>

</div>
@endsection
