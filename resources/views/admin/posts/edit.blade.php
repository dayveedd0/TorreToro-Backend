@extends('admin.layout')

@section('title', 'Edit Article - ' . $post->title)

@section('content')
<div class="max-w-4xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.posts.index') }}" class="text-xs text-stone-500 hover:text-stone-800">&larr; Back to Articles</a>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight mt-1">Edit Article: {{ $post->title }}</h1>
        </div>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-5" x-data="{ previewImg: '{{ $post->featured_image }}' }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Article Title *</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Author Name</label>
                <input type="text" name="author_name" value="{{ old('author_name', $post->author_name) }}"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Read Time Estimate</label>
                <input type="text" name="read_time" value="{{ old('read_time', $post->read_time) }}"
                       class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">
            </div>

            <div class="flex items-center space-x-2 pt-6">
                <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $post->is_published) ? 'checked' : '' }} class="rounded border-stone-300 text-brand-900 focus:ring-brand-900">
                <label for="is_published" class="text-xs font-medium text-stone-700">Published</label>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Article Excerpt</label>
            <textarea name="excerpt" rows="2"
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div class="p-4 bg-stone-50 rounded-lg border border-stone-200">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider">Featured Cover Image</label>
                <button type="button" @click="window.openMediaPicker(url => previewImg = url, 'image')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2.5 py-1 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Choose from Media Library</span>
                </button>
            </div>
            <div class="flex items-center space-x-4">
                <img :src="previewImg" class="w-24 h-16 object-cover rounded border border-stone-300 bg-stone-200" onerror="this.src='https://placehold.co/160x100?text=Article'">
                <div class="flex-1 space-y-2">
                    <input type="file" name="featured_image_file" @change="previewImg = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:bg-stone-800 file:text-white cursor-pointer">
                    <input type="text" name="featured_image" x-model="previewImg" placeholder="/storage/uploads/..." class="w-full px-3 py-1.5 border border-stone-300 rounded text-xs bg-white">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-stone-700 uppercase tracking-wider mb-1">Full Article Body (HTML / Content)</label>
            <textarea name="content" rows="10"
                      class="w-full px-3 py-2 border border-stone-300 rounded-lg text-sm focus:ring-1 focus:ring-brand-900 focus:outline-none font-mono text-xs">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 border border-stone-300 text-stone-700 text-xs font-medium rounded-lg hover:bg-stone-50">Cancel</a>
            <button type="submit" class="px-5 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm">Update Article</button>
        </div>
    </form>

</div>
@endsection
