@extends('admin.layout')

@section('title', 'Edit Service - ' . $service->title)

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.services.index') }}" class="text-xs text-stone-500 hover:text-stone-800">&larr; Back to Services</a>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight mt-1">Edit Service: {{ $service->title }}</h1>
        </div>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-5" x-data="{ previewImg: '{{ $service->thumbnail_image }}' }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Service Title *</label>
                <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">URL Slug *</label>
                <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" required
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Subtitle / Headline</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $service->subtitle) }}"
                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Short Excerpt (Grid Card Preview)</label>
            <textarea name="excerpt" rows="2"
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">{{ old('excerpt', $service->excerpt) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Full Service Description (HTML / Body)</label>
            <textarea name="description" rows="8"
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono text-xs">{{ old('description', $service->description) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Key Features / Deliverables (One per line)</label>
            <textarea name="features" rows="4"
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">{{ old('features', implode("\n", $service->features ?? [])) }}</textarea>
        </div>

        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider">Service Cover / Icon Photography</label>
                <button type="button" @click="window.openMediaPicker(url => previewImg = url, 'image')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2.5 py-1 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Choose from Media Library</span>
                </button>
            </div>
            <div class="flex items-center space-x-4">
                <img :src="previewImg" class="w-24 h-16 object-cover rounded border border-stone-300 bg-stone-200" onerror="this.src='https://placehold.co/160x100?text=Service'">
                <div class="flex-1 space-y-2">
                    <input type="file" name="thumbnail_image_file" @change="previewImg = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer">
                    <input type="text" name="thumbnail_image" x-model="previewImg" placeholder="/storage/uploads/services/..." class="w-full px-3 py-1.5 border border-stone-300 rounded text-xs bg-white">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Display Order</label>
                <input type="number" name="order" value="{{ old('order', $service->order) }}"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div class="flex items-center space-x-2 pt-6">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }} class="rounded border-stone-300 text-brand-900 focus:ring-brand-900">
                <label for="is_featured" class="text-xs font-medium text-stone-700">Show on Homepage</label>
            </div>

            <div class="flex items-center space-x-2 pt-6">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="rounded border-stone-300 text-brand-900 focus:ring-brand-900">
                <label for="is_active" class="text-xs font-medium text-stone-700">Active / Published</label>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 text-xs font-medium rounded-lg hover:bg-stone-50">Cancel</a>
            <button type="submit" class="px-5 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm">Update Service</button>
        </div>
    </form>

</div>
@endsection
