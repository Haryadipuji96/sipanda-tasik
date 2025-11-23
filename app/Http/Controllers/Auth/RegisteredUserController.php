<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view with users list.
     */
    public function create(): View
    {
        if (!Auth::user()->canCrud('users')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::with('permissions')->latest()->paginate(10);
        $permissions = Permission::all();
        return view('auth.register', compact('users', 'permissions'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::user()->canCrud('users')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'in:superadmin,admin,user'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Attach permissions untuk admin
        if ($request->role === 'admin' && $request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        event(new Registered($user));

        return redirect()->route('register')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if (!Auth::user()->canCrud('users')) {
            abort(403, 'Unauthorized action.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:superadmin,admin,user'],
        ];

        // Only validate password if provided
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        // Validasi permissions hanya untuk role admin
        if ($request->role === 'admin') {
            $rules['permissions'] = ['required', 'array', 'min:1'];
            $rules['permissions.*'] = ['exists:permissions,id'];
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update permissions untuk admin
        if ($request->role === 'admin') {
            $user->permissions()->sync($request->permissions);
        } else {
            // Hapus permissions jika role bukan admin
            $user->permissions()->detach();
        }

        return redirect()->route('register')->with('success', 'Pengguna berhasil diupdate!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (!Auth::user()->canCrud('users')) {
            abort(403, 'Unauthorized action.');
        }
        
        // Prevent deleting own account
        if (Auth::id() === $user->id) {
            return redirect()->route('register')->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('register')->with('success', 'Pengguna berhasil dihapus!');
    }
}