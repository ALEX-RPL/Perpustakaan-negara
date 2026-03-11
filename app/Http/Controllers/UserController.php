<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users'],
            'password'   => ['required', 'confirmed', Password::min(8)],
            'role'       => ['required', 'in:administrator,petugas,peminjam'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat'     => ['nullable', 'string', 'max:500'],
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'       => ['required', 'in:administrator,petugas,peminjam'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat'     => ['nullable', 'string', 'max:500'],
            'password'   => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $data = $request->only('name', 'email', 'role', 'no_telepon', 'alamat');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $activePeminjaman = $user->peminjaman()
            ->whereIn('status', ['menunggu', 'dipinjam'])->count();

        if ($activePeminjaman > 0) {
            return back()->with('error', 'User masih memiliki peminjaman aktif.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
