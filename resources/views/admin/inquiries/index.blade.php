@extends('admin.layout')

@section('title', 'Inquiries & Expert Appointments')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight">Client Inquiries & Appointments</h1>
            <p class="text-xs text-stone-500 mt-1">Review contact inquiries and appointment booking requests for {{ $domain->name }}.</p>
        </div>

        <!-- Filter tabs -->
        <div class="flex items-center space-x-2 text-xs">
            <a href="{{ route('admin.inquiries.index') }}" class="px-3 py-1.5 rounded-lg border {{ !request('status') ? 'bg-stone-900 text-white border-stone-900' : 'bg-white text-stone-600 border-stone-200' }}">All</a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" class="px-3 py-1.5 rounded-lg border {{ request('status') === 'new' ? 'bg-brand-900 text-white border-brand-900' : 'bg-white text-stone-600 border-stone-200' }}">New</a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}" class="px-3 py-1.5 rounded-lg border {{ request('status') === 'contacted' ? 'bg-stone-900 text-white border-stone-900' : 'bg-white text-stone-600 border-stone-200' }}">Contacted</a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'resolved']) }}" class="px-3 py-1.5 rounded-lg border {{ request('status') === 'resolved' ? 'bg-stone-900 text-white border-stone-900' : 'bg-white text-stone-600 border-stone-200' }}">Resolved</a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="py-3 px-6">Type</th>
                    <th class="py-3 px-6">Client / Company</th>
                    <th class="py-3 px-6">Service Requested</th>
                    <th class="py-3 px-6">Message Preview</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Received</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($inquiries as $inquiry)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="py-3.5 px-6">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $inquiry->type === 'expert_appointment' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ str_replace('_', ' ', strtoupper($inquiry->type)) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 font-medium text-stone-900">
                            {{ $inquiry->name }}
                            @if($inquiry->company)
                                <div class="text-[11px] text-stone-400 font-normal">{{ $inquiry->company }}</div>
                            @endif
                            <div class="text-[11px] text-stone-500 font-normal">{{ $inquiry->email }}</div>
                        </td>
                        <td class="py-3.5 px-6 text-stone-700">
                            {{ $inquiry->service_requested ?: 'General Architecture' }}
                        </td>
                        <td class="py-3.5 px-6 text-stone-500 max-w-xs truncate">
                            {{ $inquiry->message ?: 'No message provided' }}
                        </td>
                        <td class="py-3.5 px-6">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $inquiry->status === 'new' ? 'bg-red-100 text-red-800' : ($inquiry->status === 'contacted' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                {{ strtoupper($inquiry->status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-stone-400">
                            {{ $inquiry->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700">Review</a>
                            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="inline" onsubmit="return confirm('Delete this inquiry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-stone-400 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-stone-400">No inquiries found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($inquiries->hasPages())
            <div class="px-6 py-3 border-t border-stone-200">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
