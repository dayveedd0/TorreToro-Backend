@extends('admin.layout')

@section('title', 'Portfolio Projects')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Portfolio & Projects</h1>
            <p class="text-xs text-stone-500 mt-1">Manage architectural case studies, fit-out showcases, and special projects for {{ $domain->name }}.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
            <span>+ Add New Project</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="py-3 px-6">Project Title</th>
                    <th class="py-3 px-6">Client & Location</th>
                    <th class="py-3 px-6">Category</th>
                    <th class="py-3 px-6">Year / Stats</th>
                    <th class="py-3 px-6">Featured</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($projects as $project)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="py-3.5 px-6">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $project->thumbnail_image ?: '/storage/uploads/projects/sanlam-insurance-1.jpg' }}" class="w-12 h-9 object-cover rounded border border-stone-200 bg-stone-100 flex-shrink-0" onerror="this.src='/storage/uploads/projects/sanlam-insurance-1.jpg'">
                                <div>
                                    <div class="font-bold text-stone-900 text-sm flex items-center space-x-1.5">
                                        <span>{{ $project->title }}</span>
                                        @if(!empty($project->gallery_images) && count($project->gallery_images) > 0)
                                            <span class="inline-flex items-center space-x-0.5 text-[10px] bg-stone-100 text-stone-700 font-mono px-1.5 py-0.2 rounded border border-stone-200" title="{{ count($project->gallery_images) }} gallery photos">
                                                <svg class="w-2.5 h-2.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span>{{ count($project->gallery_images) }}</span>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-stone-400 font-mono">/portfolio/{{ $project->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-6">
                            <div class="font-medium text-stone-800">{{ $project->client_name ?: 'Confidential Client' }}</div>
                            <div class="text-[11px] text-stone-400">{{ $project->location ?: 'Location N/A' }}</div>
                        </td>
                        <td class="py-3.5 px-6">
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-stone-100 text-stone-700">
                                {{ $project->category?->name ?: 'General' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-stone-600">
                            <div>Year: {{ $project->year ?: '-' }}</div>
                            @if(!empty($project->stats['area']))
                                <div class="text-[11px] text-stone-400">Area: {{ $project->stats['area'] }}</div>
                            @endif
                        </td>
                        <td class="py-3.5 px-6">
                            @if($project->is_featured)
                                <span class="bg-brand-100 text-brand-900 text-[10px] font-bold px-2 py-0.5 rounded-full">FEATURED</span>
                            @else
                                <span class="text-stone-400 text-[10px]">Standard</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700">Edit</a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-stone-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-stone-400">No projects added yet for this domain.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
