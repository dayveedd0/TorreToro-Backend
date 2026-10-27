@extends('admin.layout')

@section('title', 'Client Reviews & Testimonials')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-stone-200">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-700"></span>
                <span class="text-xs uppercase tracking-widest font-bold text-stone-500 font-mono">Social Proof</span>
            </div>
            <h1 class="text-2xl font-serif font-bold text-stone-900 mt-1">Client Reviews & Testimonials</h1>
            <p class="text-xs sm:text-sm text-stone-600 mt-1">
                Manage executive client feedback, star ratings, and corporate praise for 
                <span class="font-bold text-brand-800">{{ $domain->name }}</span>.
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 text-xs font-bold rounded-lg bg-brand-800 hover:bg-brand-900 text-white shadow transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Review</span>
            </a>
        </div>
    </div>

    @if($testimonials->isEmpty())
        <div class="bg-white rounded-xl border border-stone-200 p-12 text-center shadow-sm">
            <svg class="w-12 h-12 text-stone-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <h3 class="text-sm font-bold text-stone-800">No client reviews registered yet</h3>
            <p class="text-xs text-stone-500 mt-1">Click "Add New Review" to publish client feedback and corporate endorsements.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $review)
                <div class="bg-white rounded-xl border border-stone-200 shadow-sm p-6 flex flex-col justify-between hover:border-brand-200 transition">
                    <div>
                        <!-- Header & Rating -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-amber-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            @if($review->is_featured)
                                <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Featured</span>
                            @endif
                        </div>

                        <!-- Quote -->
                        <p class="text-xs text-stone-700 italic leading-relaxed mb-6">
                            &ldquo;{{ Str::limit($review->quote, 180) }}&rdquo;
                        </p>
                    </div>

                    <!-- Author Info & Actions -->
                    <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($review->avatar_image)
                                <img src="{{ $review->avatar_image }}" class="w-10 h-10 rounded-full object-cover border border-stone-200 shadow-sm" alt="{{ $review->client_name }}">
                            @else
                                <div class="w-10 h-10 rounded-full bg-stone-100 text-stone-600 flex items-center justify-center font-bold text-xs border border-stone-200">
                                    {{ substr($review->client_name, 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-xs font-bold text-stone-900">{{ $review->client_name }}</h4>
                                <p class="text-[10px] text-stone-500">{{ $review->client_role ? $review->client_role . ' • ' : '' }}{{ $review->company_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.testimonials.edit', $review) }}" class="text-xs text-stone-600 hover:text-brand-800 font-medium">Edit</a>
                            <form action="{{ route('admin.testimonials.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-stone-400 hover:text-rose-600">&times;</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
