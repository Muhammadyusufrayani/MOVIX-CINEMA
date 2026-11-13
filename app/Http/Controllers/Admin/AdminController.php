<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->latest()
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = true;
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Akun admin "' . $validated['name'] . '" telah ditambahkan.');
    }

    public function edit(User $admin)
    {
        if (!$admin->is_admin) {
            abort(404);
        }

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        if (!$admin->is_admin) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        ]);

        $admin->update($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Akun admin "' . $admin->name . '" telah diperbarui.');
    }

    public function updatePassword(Request $request, User $admin)
    {
        if (!$admin->is_admin) {
            abort(404);
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $admin->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password admin "' . $admin->name . '" telah diubah.');
    }

    public function destroy(User $admin)
    {
        if (!$admin->is_admin) {
            abort(404);
        }

        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $name = $admin->name;
        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Akun admin "' . $name . '" telah dihapus.');
    }
}