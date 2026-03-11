<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('createdBy');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($q2) use ($q) {
                $q2->where('judul', 'like', "%{$q}%")
                   ->orWhere('pengarang', 'like', "%{$q}%")
                   ->orWhere('kode_buku', 'like', "%{$q}%")
                   ->orWhere('isbn', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku = $query->latest()->paginate(10)->withQueryString();
        $kategori = Buku::distinct()->pluck('kategori');

        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => ['required', 'string', 'max:255'],
            'pengarang'    => ['required', 'string', 'max:255'],
            'penerbit'     => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'isbn'         => ['nullable', 'string', 'unique:buku', 'max:20'],
            'kategori'     => ['required', 'string', 'max:100'],
            'stok'         => ['required', 'integer', 'min:0'],
            'deskripsi'    => ['nullable', 'string'],
            'cover'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $validated['kode_buku']      = Buku::generateKode();
        $validated['stok_tersedia']  = $validated['stok'];
        $validated['created_by']     = Auth::id();

        Buku::create($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load(['peminjaman.user', 'createdBy']);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'        => ['required', 'string', 'max:255'],
            'pengarang'    => ['required', 'string', 'max:255'],
            'penerbit'     => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'isbn'         => ['nullable', 'string', 'max:20', 'unique:buku,isbn,' . $buku->id],
            'kategori'     => ['required', 'string', 'max:100'],
            'stok'         => ['required', 'integer', 'min:0'],
            'deskripsi'    => ['nullable', 'string'],
            'cover'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_active'    => ['boolean'],
        ]);

        // Adjust stok_tersedia based on stok change
        $selisih = $validated['stok'] - $buku->stok;
        $validated['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);

        if ($request->hasFile('cover')) {
            if ($buku->cover) Storage::disk('public')->delete($buku->cover);
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $activePeminjaman = $buku->peminjaman()
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($activePeminjaman > 0) {
            return back()->with('error', 'Buku tidak dapat dihapus karena masih ada peminjaman aktif.');
        }

        if ($buku->cover) Storage::disk('public')->delete($buku->cover);
        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    // For peminjam - browse books
    public function catalog(Request $request)
    {
        $query = Buku::where('is_active', true);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($q2) use ($q) {
                $q2->where('judul', 'like', "%{$q}%")
                   ->orWhere('pengarang', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku    = $query->latest()->get();
        $kategori = Buku::where('is_active', true)->distinct()->pluck('kategori');

        return view('peminjam.katalog', compact('buku', 'kategori'));
    }
}
