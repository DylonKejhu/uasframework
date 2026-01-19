<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();

        // Validasi dasar
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['owner', 'admin', 'user'])],
        ]);

        // RULE 1: User tidak bisa mengubah role dirinya sendiri
        if ($user->id === $currentUser->id && $validated['role'] !== $user->role) {
            return redirect()->back()
                ->withErrors(['role' => 'Anda tidak dapat mengubah role Anda sendiri.'])
                ->withInput();
        }

        // RULE 2: Owner tidak bisa dipindah ke role lain oleh siapapun (termasuk owner lain)
        if ($user->isOwner() && $validated['role'] !== 'owner') {
            return redirect()->back()
                ->withErrors(['role' => 'Role Owner tidak dapat diubah.'])
                ->withInput();
        }

        // RULE 3: Tidak ada yang bisa membuat user baru menjadi owner
        if (!$user->isOwner() && $validated['role'] === 'owner') {
            return redirect()->back()
                ->withErrors(['role' => 'Tidak dapat mengubah role menjadi Owner.'])
                ->withInput();
        }

        // RULE 4: Admin tidak bisa mengubah role admin lain
        if ($currentUser->isAdmin() && $user->isAdmin() && $user->id !== $currentUser->id) {
            return redirect()->back()
                ->withErrors(['role' => 'Anda tidak dapat mengubah role Admin lain.'])
                ->withInput();
        }

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        // Tidak bisa hapus diri sendiri
        if ($user->id === $currentUser->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Tidak bisa hapus Owner
        if ($user->isOwner()) {
            return redirect()->route('users.index')
                ->with('error', 'Akun Owner tidak dapat dihapus.');
        }

        // Admin tidak bisa hapus admin lain
        if ($currentUser->isAdmin() && $user->isAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus Admin lain.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}