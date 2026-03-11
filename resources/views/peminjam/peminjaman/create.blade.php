@extends('layouts.app')
@section('title','Pinjam Buku')
@section('page-title','Pinjam Buku')
@section('content')

<div style="max-width:640px;margin:0 auto;">
    {{-- Book preview card --}}
    <div class="card mb-4">
        <div style="padding:20px;display:flex;gap:16px;align-items:flex-start;">
            @php $c=[['#eef2ff','#c7d2fe','#6366f1'],['#eff6ff','#bfdbfe','#3b82f6'],['#fdf4ff','#e9d5ff','#8b5cf6'],['#ecfdf5','#a7f3d0','#10b981']][($buku->id-1)%4]; @endphp
            <div style="width:64px;height:88px;border-radius:10px;background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }});display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                @if($buku->cover)
                <img src="{{ Storage::url($buku->cover) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                <i class="bi bi-book-fill" style="font-size:24px;color:{{ $c[2] }};"></i>
                @endif
            </div>
            <div style="flex:1;">
                <div class="flex items-center gap-2 mb-1">
                    <span class="badge b-purple">{{ $buku->kategori }}</span>
                    <span class="badge b-green">{{ $buku->stok_tersedia }} tersedia</span>
                </div>
                <h3 style="font-family:'Outfit',sans-serif;font-size:17px;font-weight:700;letter-spacing:-.02em;margin-bottom:4px;">{{ $buku->judul }}</h3>
                <p class="text-sm text-muted">{{ $buku->pengarang }} — {{ $buku->penerbit }}, {{ $buku->tahun_terbit }}</p>
                @if($buku->deskripsi)
                <p class="text-sm" style="color:#64748b;margin-top:8px;line-height:1.5;">{{ Str::limit($buku->deskripsi,120) }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-calendar-event" style="color:#6366f1;"></i> Detail Peminjaman</div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('peminjam.peminjaman.store') }}">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                <div class="grid g2 mb-3" style="gap:14px;">
                    <div class="fg">
                        <label class="lbl">Tanggal Pinjam</label>
                        <input type="text" class="input" value="{{ now()->format('d M Y') }}" disabled style="opacity:.6;cursor:not-allowed;">
                    </div>
                    <div class="fg">
                        <label class="lbl">Tanggal Kembali <span class="req">*</span></label>
                        <input type="date" name="tanggal_kembali_rencana"
                            class="input {{ $errors->has('tanggal_kembali_rencana')?'invalid':'' }}"
                            min="{{ now()->addDay()->toDateString() }}"
                            max="{{ now()->addDays(14)->toDateString() }}"
                            value="{{ old('tanggal_kembali_rencana') }}"
                            required id="returnDate" onchange="updateDays()">
                        @error('tanggal_kembali_rencana')<div class="err">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Duration indicator --}}
                <div id="durationBox" class="card mb-3" style="background:#f8fafc;border:1.5px dashed #e2e8f0;display:none;">
                    <div style="padding:12px 16px;" class="flex items-center gap-3">
                        <i class="bi bi-clock-fill" style="color:#6366f1;font-size:16px;"></i>
                        <div>
                            <span class="text-sm font-sem">Durasi peminjaman: </span>
                            <span id="daysCount" class="font-sem" style="color:#6366f1;"></span>
                        </div>
                    </div>
                </div>

                <div class="fg mb-4">
                    <label class="lbl">Catatan (opsional)</label>
                    <textarea name="catatan" class="textarea" rows="2" placeholder="Pesan untuk petugas...">{{ old('catatan') }}</textarea>
                </div>

                <div class="card mb-4" style="background:#eff6ff;border-color:#bfdbfe;">
                    <div style="padding:12px 15px;" class="flex items-start gap-2">
                        <i class="bi bi-info-circle-fill" style="color:#3b82f6;margin-top:1px;"></i>
                        <div class="text-sm">
                            <strong style="color:#1e40af;">Ketentuan Peminjaman</strong><br>
                            <span style="color:#3b82f6;">• Denda keterlambatan Rp 1.000/hari &nbsp;• Maksimal 3 buku aktif &nbsp;• Peminjaman diproses setelah disetujui petugas</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                        <i class="bi bi-send-fill"></i> Ajukan Peminjaman
                    </button>
                    <a href="{{ route('peminjam.katalog') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateDays() {
    const val = document.getElementById('returnDate').value;
    if (!val) { document.getElementById('durationBox').style.display='none'; return; }
    const diff = Math.round((new Date(val) - new Date()) / 86400000);
    document.getElementById('daysCount').textContent = diff + ' hari';
    document.getElementById('durationBox').style.display = 'block';
}
</script>
@endpush
@endsection
