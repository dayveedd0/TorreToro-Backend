@extends('admin.layout')

@section('title', 'Review Inquiry')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.inquiries.index') }}" class="text-xs text-stone-500 hover:text-stone-800">&larr; Back to Inquiries</a>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight mt-1">
                Inquiry Details: {{ $inquiry->name }}
            </h1>
        </div>

        <div>
            <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST" class="inline flex items-center space-x-2">
                @csrf
                <label class="text-xs font-semibold text-stone-500">Status:</label>
                <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border border-stone-300 px-3 py-1.5 focus:ring-brand-900">
                    <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>NEW</option>
                    <option value="in_progress" {{ $inquiry->status === 'in_progress' ? 'selected' : '' }}>IN PROGRESS</option>
                    <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>CONTACTED</option>
                    <option value="resolved" {{ $inquiry->status === 'resolved' ? 'selected' : '' }}>RESOLVED</option>
                    <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>CLOSED</option>
                </select>
            </form>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-stone-200 shadow-sm space-y-6">
        <!-- Client Profile -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-stone-100">
            <div>
                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider">Client Name</span>
                <span class="text-sm font-bold text-stone-900">{{ $inquiry->name }}</span>
            </div>

            <div>
                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider">Company / Organization</span>
                <span class="text-sm font-medium text-stone-800">{{ $inquiry->company ?: 'Individual / Not Specified' }}</span>
            </div>

            <div>
                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider">Email</span>
                <a href="mailto:{{ $inquiry->email }}" class="text-sm font-medium text-brand-900 hover:underline">{{ $inquiry->email }}</a>
            </div>

            <div>
                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider">Phone</span>
                <a href="tel:{{ $inquiry->phone }}" class="text-sm font-medium text-stone-800">{{ $inquiry->phone ?: 'No phone provided' }}</a>
            </div>

            <div>
                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider">Inquiry Type</span>
                <span class="inline-block mt-0.5 px-2.5 py-0.5 rounded text-xs font-semibold bg-stone-100 text-stone-800">
                    {{ str_replace('_', ' ', strtoupper($inquiry->type)) }}
                </span>
            </div>

            <div>
                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider">Service Requested</span>
                <span class="text-sm font-medium text-stone-800">{{ $inquiry->service_requested ?: 'General' }}</span>
            </div>
        </div>

        <!-- Message Body -->
        <div>
            <h3 class="text-xs font-semibold text-stone-400 uppercase tracking-wider mb-2">Message / Client Brief</h3>
            <div class="bg-stone-50 p-4 rounded-lg border border-stone-200 text-sm text-stone-800 whitespace-pre-wrap leading-relaxed font-sans">
                {{ $inquiry->message ?: 'No additional message was submitted.' }}
            </div>
        </div>

        <div class="text-xs text-stone-400 pt-2 flex justify-between items-center">
            <span>Submitted on {{ $inquiry->created_at->format('F d, Y \a\t H:i:s') }} ({{ $inquiry->created_at->diffForHumans() }})</span>
            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-600 hover:underline">Delete record</button>
            </form>
        </div>
    </div>

</div>
@endsection
