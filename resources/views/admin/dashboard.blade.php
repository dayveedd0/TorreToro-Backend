@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Top Headline & Domain Status -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Overview & Performance</h1>
            <p class="text-xs text-stone-500 mt-1">
                Viewing data for: <strong class="text-brand-900">{{ $domain->name }}</strong> ({{ strtoupper($domain->code) }})
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center space-x-1.5 px-3 py-2 bg-stone-900 hover:bg-stone-800 text-white text-xs font-medium rounded-lg shadow-sm transition">
                <span>+ New Service</span>
            </a>
            <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center space-x-1.5 px-3 py-2 bg-brand-900 hover:bg-brand-800 text-white text-xs font-medium rounded-lg shadow-sm transition">
                <span>+ New Project</span>
            </a>
        </div>
    </div>

    <!-- Stat Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- New Inquiries -->
        <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">New Inquiries</div>
                    <div class="text-2xl font-bold text-brand-900 mt-1">{{ $stats['inquiries_new'] }}</div>
                    <div class="text-[11px] text-stone-400 mt-1">{{ $stats['inquiries_total'] }} total received</div>
                </div>
                <div class="p-2.5 rounded-lg bg-brand-50 text-brand-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Active Services</div>
                    <div class="text-2xl font-bold text-stone-900 mt-1">{{ $stats['services_count'] }}</div>
                    <div class="text-[11px] text-stone-400 mt-1">Architecture & Interiors</div>
                </div>
                <div class="p-2.5 rounded-lg bg-stone-100 text-stone-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>

        <!-- Portfolio Projects -->
        <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Projects Showcased</div>
                    <div class="text-2xl font-bold text-stone-900 mt-1">{{ $stats['projects_count'] }}</div>
                    <div class="text-[11px] text-stone-400 mt-1">Portfolio Archive</div>
                </div>
                <div class="p-2.5 rounded-lg bg-stone-100 text-stone-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <!-- News / Insights -->
        <div class="bg-white p-5 rounded-xl border border-stone-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Published Articles</div>
                    <div class="text-2xl font-bold text-stone-900 mt-1">{{ $stats['posts_count'] }}</div>
                    <div class="text-[11px] text-stone-400 mt-1">Blog & News Section</div>
                </div>
                <div class="p-2.5 rounded-lg bg-stone-100 text-stone-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries & Appointments -->
    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-stone-900 uppercase tracking-wider">Recent Inquiries & Expert Appointments</h2>
                <p class="text-xs text-stone-500">Submissions from contact forms & "Get an appointment with our Expert"</p>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700">
                View all &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-6">Client / Sender</th>
                        <th class="py-3 px-6">Type & Service</th>
                        <th class="py-3 px-6">Contact Info</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6">Date</th>
                        <th class="py-3 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($recentInquiries as $inquiry)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3.5 px-6 font-medium text-stone-900">
                                {{ $inquiry->name }}
                                @if($inquiry->company)
                                    <span class="block text-[11px] text-stone-400 font-normal">{{ $inquiry->company }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold {{ $inquiry->type === 'expert_appointment' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ str_replace('_', ' ', strtoupper($inquiry->type)) }}
                                </span>
                                <div class="text-[11px] text-stone-500 mt-0.5">{{ $inquiry->service_requested ?: 'General' }}</div>
                            </td>
                            <td class="py-3.5 px-6 text-stone-600">
                                <div>{{ $inquiry->email }}</div>
                                <div class="text-stone-400">{{ $inquiry->phone ?: 'No phone' }}</div>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $inquiry->status === 'new' ? 'bg-red-100 text-red-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ strtoupper($inquiry->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-stone-400">
                                {{ $inquiry->created_at->diffForHumans() }}
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-stone-400">
                                No inquiries or bookings received yet for this domain.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
