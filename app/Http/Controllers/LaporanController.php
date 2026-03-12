<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis'         => ['required', 'in:peminjaman,keterlambatan,buku_populer,anggota'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $mulai  = Carbon::parse($request->tanggal_mulai)->startOfDay();
        $akhir  = Carbon::parse($request->tanggal_akhir)->endOfDay();

        $data = match($request->jenis) {
            'peminjaman' => $this->laporanPeminjaman($mulai, $akhir),
            'keterlambatan' => $this->laporanKeterlambatan($mulai, $akhir),
            'buku_populer' => $this->laporanBukuPopuler($mulai, $akhir),
            'anggota' => $this->laporanAnggota($mulai, $akhir),
        };

        return view('admin.laporan.hasil', array_merge($data, [
            'jenis'         => $request->jenis,
            'tanggal_mulai' => $mulai,
            'tanggal_akhir' => $akhir,
        ]));
    }

    private function laporanPeminjaman($mulai, $akhir): array
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->whereDate('tanggal_pinjam', '>=', $mulai)
            ->whereDate('tanggal_pinjam', '<=', $akhir)
            ->latest()
            ->get();

        $stats = [
            'total'        => $peminjaman->count(),
            'dipinjam'     => $peminjaman->where('status', 'dipinjam')->count(),
            'dikembalikan' => $peminjaman->where('status', 'dikembalikan')->count(),
            'terlambat'    => $peminjaman->where('status', 'terlambat')->count(),
            'ditolak'      => $peminjaman->where('status', 'ditolak')->count(),
            'total_denda'  => $peminjaman->sum('denda'),
        ];

        return compact('peminjaman', 'stats');
    }

    private function laporanKeterlambatan($mulai, $akhir): array
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['terlambat', 'dikembalikan'])
            ->where('denda', '>', 0)
            ->whereDate('tanggal_pinjam', '>=', $mulai)
            ->whereDate('tanggal_pinjam', '<=', $akhir)
            ->latest()
            ->get();

        $stats = [
            'total_kasus'  => $peminjaman->count(),
            'total_denda'  => $peminjaman->sum('denda'),
            'rata_denda'   => $peminjaman->avg('denda'),
        ];

        return compact('peminjaman', 'stats');
    }

    private function laporanBukuPopuler($mulai, $akhir): array
    {
        $buku = Buku::withCount(['peminjaman' => function($q) use ($mulai, $akhir) {
                $q->whereDate('tanggal_pinjam', '>=', $mulai)
                  ->whereDate('tanggal_pinjam', '<=', $akhir);
            }])
            ->orderByDesc('peminjaman_count')
            ->limit(20)
            ->get();

        $stats = [
            'total_buku'      => Buku::count(),
            'buku_tersedia'   => Buku::where('stok_tersedia', '>', 0)->count(),
            'total_dipinjam'  => $buku->sum('peminjaman_count'),
        ];

        return compact('buku', 'stats');
    }

    private function laporanAnggota($mulai, $akhir): array
    {
        $anggota = User::where('role', 'peminjam')
            ->withCount(['peminjaman' => function($q) use ($mulai, $akhir) {
                $q->whereDate('tanggal_pinjam', '>=', $mulai)
                  ->whereDate('tanggal_pinjam', '<=', $akhir);
            }])
            ->orderByDesc('peminjaman_count')
            ->get();

        $stats = [
            'total_anggota' => $anggota->count(),
            'anggota_aktif' => $anggota->where('is_active', true)->count(),
        ];

        return compact('anggota', 'stats');
    }
}
