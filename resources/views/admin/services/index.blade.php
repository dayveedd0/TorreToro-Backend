@extends('admin.layout')

@section('title', 'Services Management')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Services Catalog</h1>
            <p class="text-xs text-stone-500 mt-1">Manage architectural, interior design, and consultancy service offerings for {{ $domain->name }}.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-semibold rounded-lg shadow-sm transition">
            <span>+ Add New Service</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="py-3 px-6">Order</th>
                    <th class="py-3 px-6">Service Title & Subtitle</th>
                    <th class="py-3 px-6">Slug</th>
                    <th class="py-3 px-6">Features / Offerings</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($services as $service)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="py-3.5 px-6 font-mono text-stone-400 font-semibold">{{ $service->order }}</td>
                        <td class="py-3.5 px-6">
                            <div class="font-bold text-stone-900 text-sm">{{ $service->title }}</div>
                            <div class="text-[11px] text-stone-500 truncate max-w-sm">{{ $service->subtitle }}</div>
                        </td>
                        <td class="py-3.5 px-6 font-mono text-[11px] text-stone-500">
                            /services/{{ $service->slug }}
                        </td>
                        <td class="py-3.5 px-6 text-stone-600">
                            {{ count($service->features ?? []) }} highlighted points
                        </td>
                        <td class="py-3.5 px-6">
                            @if($service->is_active)
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">ACTIVE</span>
                            @else
                                <span class="bg-stone-200 text-stone-600 text-[10px] font-bold px-2 py-0.5 rounded-full">DRAFT</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700">Edit</a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-stone-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-stone-400">No services configured yet for this domain.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
