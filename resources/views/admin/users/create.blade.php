@extends('admin.layout')

@section('title', 'Create Admin User')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-stone-200">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-600"></span>
                <span class="text-xs uppercase tracking-widest font-bold text-stone-500 font-mono">User Management</span>
            </div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight mt-1">Create New Admin User</h1>
            <p class="text-xs text-stone-500 mt-0.5">Provision an administrator, assign roles, and grant granular platform permissions.</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-stone-600 hover:text-stone-900 border border-stone-300 rounded-lg px-3 py-2 bg-white transition">
            &larr; Back to Users
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-stone-200 p-6 space-y-6" x-data="{ selectedRole: 'editor' }">
        @csrf

        <!-- Basic Info Section -->
        <div>
            <h2 class="text-sm font-bold text-stone-900 uppercase tracking-wider mb-4 pb-2 border-b border-stone-100">1. Account Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Adeboye Damilola" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Email Address (Login) *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@torretoro.com" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Phone Number (Optional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+234 813 1111 444" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                </div>

                <div class="flex items-center space-x-3 pt-6">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-stone-300 text-brand-800 focus:ring-brand-800 w-4 h-4">
                    <label for="is_active" class="text-xs font-bold text-stone-700 cursor-pointer">Account Active & Enabled</label>
                </div>
            </div>
        </div>

        <!-- Security / Password Section -->
        <div>
            <h2 class="text-sm font-bold text-stone-900 uppercase tracking-wider mb-4 pb-2 border-b border-stone-100">2. Password Security</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="Minimum 8 characters" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-enter password" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                </div>
            </div>
        </div>

        <!-- Role & Permissions Section -->
        <div>
            <h2 class="text-sm font-bold text-stone-900 uppercase tracking-wider mb-4 pb-2 border-b border-stone-100">3. Primary Role & Permissions</h2>
            
            <div class="mb-4">
                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wide mb-1">Select System Role *</label>
                <select name="role" x-model="selectedRole" class="w-full text-xs rounded-lg border border-stone-300 p-2.5 bg-white focus:border-brand-800 focus:ring-1 focus:ring-brand-800">
                    @foreach($roles as $roleKey => $roleTitle)
                        <option value="{{ $roleKey }}" {{ old('role', 'editor') === $roleKey ? 'selected' : '' }}>
                            {{ $roleTitle }}
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-stone-500 mt-1.5" x-show="selectedRole === 'super_admin'">
                    👑 <strong>Super Administrator</strong> has full unconstrained access across all domains, user provisioning, database settings, and media.
                </p>
            </div>

            <!-- Granular Permissions Grid (Shown when not super_admin) -->
            <div x-show="selectedRole !== 'super_admin'" class="p-4 bg-stone-50 rounded-lg border border-stone-200 mt-4">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-stone-800 uppercase tracking-wider">Granular Capabilities</span>
                    <span class="text-[11px] text-stone-500">Fine-tune individual module access</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($permissions as $permKey => $permLabel)
                        <label class="flex items-start space-x-2.5 p-2 bg-white rounded border border-stone-200 hover:border-brand-300 cursor-pointer transition">
                            <input type="checkbox" name="permissions[]" value="{{ $permKey }}" 
                                   {{ is_array(old('permissions')) && in_array($permKey, old('permissions')) ? 'checked' : '' }} 
                                   class="rounded border-stone-300 text-brand-800 focus:ring-brand-800 mt-0.5">
                            <span class="text-xs text-stone-700 font-medium leading-tight">{{ $permLabel }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-stone-100">
            <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-stone-600 hover:text-stone-900 px-4 py-2 rounded-lg border border-stone-200 bg-white">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-brand-800 hover:bg-brand-900 text-white text-xs font-bold rounded-lg shadow-sm transition">
                Create User & Assign Access
            </button>
        </div>
    </form>

</div>
@endsection
