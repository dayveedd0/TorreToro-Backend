@extends('admin.layout')

@section('title', 'Admin Users & Roles')

@section('content')
<div class="space-y-6">

    <!-- Top Headline & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-600"></span>
                <span class="text-xs uppercase tracking-widest font-bold text-stone-500 font-mono">Access Control</span>
            </div>
            <h1 class="text-2xl font-bold font-serif text-stone-900 tracking-tight mt-1">Admin Users, Roles & Permissions</h1>
            <p class="text-xs text-stone-500 mt-1">Manage team members, assign administrative roles, and configure granular permissions.</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white text-xs font-semibold rounded-lg shadow-sm transition">
            <svg class="w-4 h-4 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>+ Create New Admin User</span>
        </a>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-100 flex items-center justify-between">
            <span class="text-xs font-bold text-stone-700 uppercase tracking-wider">Registered Administrators ({{ $users->total() }})</span>
            <span class="text-xs text-stone-400">Multi-domain role-based access control</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-600 border-b border-stone-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-6">User & Contact</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6">Permissions Overview</th>
                        <th class="py-3 px-6">Created</th>
                        <th class="py-3 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-stone-900 text-sm flex items-center space-x-2">
                                    <span>{{ $user->name }}</span>
                                    @if($user->id === Auth::id())
                                        <span class="text-[10px] bg-brand-50 text-brand-800 border border-brand-200 px-1.5 py-0.5 rounded font-mono font-semibold">You</span>
                                    @endif
                                </div>
                                <div class="text-stone-500 mt-0.5">{{ $user->email }}</div>
                                @if($user->phone)
                                    <div class="text-[11px] text-stone-400 font-mono mt-0.5">{{ $user->phone }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($user->role === 'super_admin')
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                        <span>👑</span>
                                        <span>Super Admin</span>
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                        <span>🛡️</span>
                                        <span>Admin</span>
                                    </span>
                                @elseif($user->role === 'editor')
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        <span>✏️</span>
                                        <span>Editor</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-stone-100 text-stone-800 border border-stone-200">
                                        <span>📝</span>
                                        <span>Author</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($user->is_active)
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Active</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-stone-200 text-stone-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                                        <span>Inactive</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                @if($user->isSuperAdmin())
                                    <span class="text-[11px] text-purple-700 font-semibold italic">Full System Access (Unrestricted)</span>
                                @elseif(!empty($user->permissions))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->permissions as $perm)
                                            <span class="text-[10px] bg-stone-100 text-stone-700 px-1.5 py-0.5 rounded font-mono">{{ str_replace('_', ' ', $perm) }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-[11px] text-stone-400">Standard Role Permissions</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-stone-400 text-[11px]">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-xs font-semibold text-brand-900 hover:text-brand-700 inline-block">Edit</a>
                                
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete user {{ $user->name }}? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 ml-2">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-stone-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-stone-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
