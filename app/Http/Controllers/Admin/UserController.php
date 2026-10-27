<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = [
            User::ROLE_SUPER_ADMIN => 'Super Administrator (Full System Access)',
            User::ROLE_ADMIN => 'Administrator (All Management except Super Admin controls)',
            User::ROLE_EDITOR => 'Editor (Manage Content, Services, Projects, Reviews)',
            User::ROLE_AUTHOR => 'Author (Create & Edit Blog Insights)',
        ];

        $permissions = User::AVAILABLE_PERMISSIONS;

        return view('admin.users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in([User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_AUTHOR])],
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', array_keys(User::AVAILABLE_PERMISSIONS)),
            'is_active' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'permissions' => $validated['permissions'] ?? [],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.users.index')->with('success', "User {$validated['name']} created successfully!");
    }

    public function edit(User $user): View
    {
        $roles = [
            User::ROLE_SUPER_ADMIN => 'Super Administrator (Full System Access)',
            User::ROLE_ADMIN => 'Administrator (All Management except Super Admin controls)',
            User::ROLE_EDITOR => 'Editor (Manage Content, Services, Projects, Reviews)',
            User::ROLE_AUTHOR => 'Author (Create & Edit Blog Insights)',
        ];

        $permissions = User::AVAILABLE_PERMISSIONS;

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in([User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_AUTHOR])],
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . implode(',', array_keys(User::AVAILABLE_PERMISSIONS)),
            'is_active' => 'nullable|boolean',
        ]);

        // Guard against removing the last super admin
        if ($user->role === User::ROLE_SUPER_ADMIN && $validated['role'] !== User::ROLE_SUPER_ADMIN) {
            $superAdminsCount = User::where('role', User::ROLE_SUPER_ADMIN)->count();
            if ($superAdminsCount <= 1) {
                return back()->with('error', 'Cannot demote the only remaining Super Administrator.');
            }
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'permissions' => $validated['permissions'] ?? [],
            'is_active' => $request->boolean('is_active', true),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', "User {$user->name} updated successfully!");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own logged-in admin account.');
        }

        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $superAdminsCount = User::where('role', User::ROLE_SUPER_ADMIN)->count();
            if ($superAdminsCount <= 1) {
                return back()->with('error', 'Cannot delete the only remaining Super Administrator.');
            }
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User {$name} deleted successfully.");
    }
}
