<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'total_buku'        => Buku::count(),
            'total_anggota'     => User::where('role', 'peminjam')->count(),
            'peminjaman_aktif'  => Peminjaman::whereIn('status', ['menunggu', 'dipinjam'])->count(),
            'peminjaman_hari_ini' => Peminjaman::whereDate('created_at', today())->count(),
            'total_denda'       => Peminjaman::sum('denda'),
        ];

        $recentPeminjaman = Peminjaman::with(['user', 'buku'])
            ->latest()->limit(5)->get();

        $menungguApproval = Peminjaman::with(['user', 'buku'])
            ->where('status', 'menunggu')->latest()->get();

        $overdueList = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', today())
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPeminjaman', 'menungguApproval', 'overdueList'));
    }

    public function petugas()
    {
        $menungguApproval = Peminjaman::with(['user', 'buku'])
            ->where('status', 'menunggu')->latest()->get();

        $dipinjam = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dipinjam')->latest()->paginate(10);

        $overdueList = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', today())
            ->get();

        $stats = [
            'menunggu'     => $menungguApproval->count(),
            'dipinjam'     => Peminjaman::where('status', 'dipinjam')->count(),
            'overdue'      => $overdueList->count(),
            'hari_ini'     => Peminjaman::whereDate('created_at', today())->count(),
        ];

        return view('petugas.dashboard', compact('menungguApproval', 'dipinjam', 'overdueList', 'stats'));
    }

    public function peminjam()
    {
        $user = Auth::user();

        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->latest()->limit(5)->get();

        $stats = [
            'total'       => Peminjaman::where('user_id', $user->id)->count(),
            'aktif'       => Peminjaman::where('user_id', $user->id)->whereIn('status', ['menunggu', 'dipinjam'])->count(),
            'selesai'     => Peminjaman::where('user_id', $user->id)->where('status', 'dikembalikan')->count(),
            'total_denda' => Peminjaman::where('user_id', $user->id)->sum('denda'),
        ];

        $bukuTerbaru = Buku::where('is_active', true)->latest()->limit(6)->get();

        return view('peminjam.dashboard', compact('peminjaman', 'stats', 'bukuTerbaru'));
    }
}
