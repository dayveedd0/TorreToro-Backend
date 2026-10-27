@extends('admin.layout')

@section('title', 'News & Insights')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">News & Insights Articles</h1>
            <p class="text-xs text-stone-500 mt-1">Manage articles, editorial pieces, and case studies published on {{ $domain->name }}.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
            <span>+ Write New Article</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="py-3 px-6">Article Title</th>
                    <th class="py-3 px-6">Category</th>
                    <th class="py-3 px-6">Author & Read Time</th>
                    <th class="py-3 px-6">Published</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($posts as $post)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="py-3.5 px-6">
                            <div class="font-bold text-stone-900 text-sm">{{ $post->title }}</div>
                            <div class="text-[11px] text-stone-400 font-mono">/news/{{ $post->slug }}</div>
                        </td>
                        <td class="py-3.5 px-6">
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-stone-100 text-stone-700">
                                {{ $post->category?->name ?: 'Editorial' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-stone-600">
                            <div>{{ $post->author_name }}</div>
                            <div class="text-[11px] text-stone-400">{{ $post->read_time }}</div>
                        </td>
                        <td class="py-3.5 px-6">
                            @if($post->is_published)
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">PUBLISHED</span>
                            @else
                                <span class="bg-stone-200 text-stone-600 text-[10px] font-bold px-2 py-0.5 rounded-full">DRAFT</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700">Edit</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-stone-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-stone-400">No articles published yet for this domain.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
