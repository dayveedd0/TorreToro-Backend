@extends('admin.layout')

@section('title', 'Add Client Review')

@section('content')
<div class="max-w-3xl mx-auto" x-data="{ previewAvatar: '' }">
    <div class="pb-6 mb-6 border-b border-stone-200 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.testimonials.index') }}" class="text-xs text-stone-500 hover:text-stone-800 font-medium mb-1 inline-block">&larr; Back to Reviews</a>
            <h1 class="text-2xl font-serif font-bold text-stone-900">Add New Client Review</h1>
            <p class="text-xs text-stone-600">Register corporate praise for {{ $domain->name }}.</p>
        </div>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Client Full Name *</label>
                <input type="text" name="client_name" value="{{ old('client_name') }}" required class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Star Rating (1 - 5) *</label>
                <select name="rating" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 bg-white">
                    <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Stars (★★★★★)</option>
                    <option value="4" {{ old('rating', 4) == 4 ? 'selected' : '' }}>4 Stars (★★★★☆)</option>
                    <option value="3" {{ old('rating', 3) == 3 ? 'selected' : '' }}>3 Stars (★★★☆☆)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Client Role / Position</label>
                <input type="text" name="client_role" value="{{ old('client_role') }}" placeholder="e.g. Managing Director" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Company / Organization</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="e.g. Sanlam Group" class="w-full text-xs rounded-lg border border-stone-300 p-2.5">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Testimonial Quote *</label>
                <textarea name="quote" rows="4" required class="w-full text-xs rounded-lg border border-stone-300 p-3 leading-relaxed" placeholder="What did the client say about Torre Tórò's architectural, interior design, or fit-out services?">{{ old('quote') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide">Client Photo / Avatar</label>
                    <button type="button" @click="window.openMediaPicker(url => previewAvatar = url, 'image')" class="text-xs bg-stone-900 hover:bg-stone-800 text-white px-2.5 py-1 rounded font-semibold flex items-center space-x-1 shadow-xs transition">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Choose from Media Library</span>
                    </button>
                </div>
                <div class="flex items-center space-x-4 p-4 bg-stone-50 rounded-lg border border-stone-200">
                    <img :src="previewAvatar" class="w-14 h-14 rounded-full object-cover border border-stone-300 bg-stone-200" onerror="this.src='/storage/uploads/team/adeboye-damilola.png'">
                    <div class="flex-1 space-y-2">
                        <input type="file" name="avatar_file" @change="previewAvatar = URL.createObjectURL($event.target.files[0])" accept="image/*" class="text-xs">
                        <input type="text" name="avatar_url" x-model="previewAvatar" placeholder="/storage/uploads/..." class="w-full text-xs rounded border border-stone-300 p-1.5">
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 flex items-center space-x-2">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', true) ? 'checked' : '' }} class="rounded border-stone-300 text-brand-700 focus:ring-brand-700">
                <label for="is_featured" class="text-xs font-medium text-stone-700">Featured Review (eligible for homepage review block)</label>
            </div>
        </div>

        <div class="pt-4 border-t border-stone-100 flex justify-end space-x-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 text-xs font-semibold rounded-lg bg-stone-200 hover:bg-stone-300 text-stone-800">Cancel</a>
            <button type="submit" class="px-5 py-2 text-xs font-bold rounded-lg bg-brand-800 hover:bg-brand-900 text-white shadow">Save Review</button>
        </div>
    </form>
</div>
@endsection
