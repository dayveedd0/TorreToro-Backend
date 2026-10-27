@extends('admin.layout')

@section('title', 'Page Content Manager')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Core Page Content</h1>
            <p class="text-xs text-stone-500 mt-1">Edit copy, hero headlines, and SEO meta tags for {{ $domain->name }}.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="py-3 px-6">Page Name</th>
                    <th class="py-3 px-6">Slug</th>
                    <th class="py-3 px-6">Hero Title Preview</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($pages as $page)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="py-3.5 px-6 font-bold text-stone-900 text-sm">
                            {{ $page->title }}
                        </td>
                        <td class="py-3.5 px-6 font-mono text-stone-400">
                            /{{ $page->slug === 'home' ? '' : $page->slug }}
                        </td>
                        <td class="py-3.5 px-6 text-stone-600 max-w-sm truncate">
                            {{ $page->hero_title ?: 'Default Title' }}
                        </td>
                        <td class="py-3.5 px-6">
                            @if($page->is_published)
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">PUBLISHED</span>
                            @else
                                <span class="bg-stone-200 text-stone-600 text-[10px] font-bold px-2 py-0.5 rounded-full">DRAFT</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            @if($page->slug === 'home')
                                <a href="{{ route('admin.home_editor.edit') }}" class="inline-flex items-center space-x-1 px-3 py-1.5 text-xs font-bold rounded-lg bg-brand-900 text-white hover:bg-brand-800 shadow-sm transition">
                                    <span>8-Section CMS Editor</span>
                                </a>
                            @else
                                <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-stone-900 text-white hover:bg-stone-800 shadow-sm transition">
                                    <span>Edit Visual CMS & Assets</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-stone-400">No pages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
