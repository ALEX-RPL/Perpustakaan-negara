<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // ═══════════════════════════════
    // PEMINJAM: Ajukan Peminjaman
    // ═══════════════════════════════
    public function create(Buku $buku)
    {
        if (!$buku->isTersedia()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $activePeminjaman = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($activePeminjaman >= 3) {
            return back()->with('error', 'Anda sudah memiliki 3 peminjaman aktif. Kembalikan buku terlebih dahulu.');
        }

        return view('peminjam.peminjaman.create', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id'                  => ['required', 'exists:buku,id'],
            'tanggal_kembali_rencana'  => ['required', 'date', 'after:today', 'before_or_equal:' . now()->addDays(14)->toDateString()],
            'catatan'                  => ['nullable', 'string', 'max:500'],
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if (!$buku->isTersedia()) {
            return back()->with('error', 'Buku tidak tersedia.');
        }

        Peminjaman::create([
            'kode_peminjaman'         => Peminjaman::generateKode(),
            'user_id'                 => Auth::id(),
            'buku_id'                 => $buku->id,
            'tanggal_pinjam'          => now(),
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status'                  => 'menunggu',
            'catatan'                 => $request->catatan,
        ]);

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Permohonan peminjaman berhasil diajukan. Tunggu persetujuan petugas.');
    }

    public function myPeminjaman()
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }

    // ═══════════════════════════════
    // PETUGAS & ADMIN: Kelola Peminjaman
    // ═══════════════════════════════
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku', 'approvedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$q}%"))
                  ->orWhereHas('buku', fn($q2) => $q2->where('judul', 'like', "%{$q}%"))
                  ->orWhere('kode_peminjaman', 'like', "%{$q}%");
        }

        $peminjaman = $query->latest()->paginate(15)->withQueryString();

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $buku = $peminjaman->buku;
        if ($buku->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $peminjaman->update([
            'status'      => 'dipinjam',
            'approved_by' => Auth::id(),
        ]);

        $buku->decrement('stok_tersedia');

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $request->validate(['catatan' => ['required', 'string', 'max:500']]);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $peminjaman->update([
            'status'      => 'ditolak',
            'catatan'     => $request->catatan,
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $tanggalAktual = Carbon::now();
        $isOverdue = $tanggalAktual->greaterThan($peminjaman->tanggal_kembali_rencana);
        $denda = 0;

        if ($isOverdue) {
            $hariTerlambat = $tanggalAktual->diffInDays($peminjaman->tanggal_kembali_rencana);
            $denda = $hariTerlambat * 1000;
        }

        $peminjaman->update([
            'status'                  => 'dikembalikan',
            'tanggal_kembali_aktual'  => $tanggalAktual,
            'denda'                   => $denda,
            'approved_by'             => Auth::id(),
        ]);

        $peminjaman->buku->increment('stok_tersedia');

        $message = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $message .= " Denda keterlambatan: Rp " . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $message);
    }
}
