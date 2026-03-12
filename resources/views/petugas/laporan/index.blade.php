@extends('layouts.app')
@section('title','Laporan')
@section('page-title','Generate Laporan')
@section('content')
@php $prefix = auth()->user()->isAdministrator() ? 'admin' : 'petugas'; @endphp

<div style="max-width:640px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-bar-chart-fill" style="color:#6366f1;"></i> Parameter Laporan</div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route($prefix.'.laporan.generate') }}">
                @csrf
                <div class="fg">
                    <label class="lbl">Jenis Laporan <span class="req">*</span></label>
                    <div class="grid g2" style="gap:10px;margin-bottom:4px;">
                        @php
                        $types = [
                            'peminjaman'    => ['bi-arrow-left-right','Peminjaman','Semua transaksi','b-blue'],
                            'keterlambatan' => ['bi-exclamation-triangle','Keterlambatan','Denda & overdue','b-red'],
                            'buku_populer'  => ['bi-star-fill','Buku Populer','Top koleksi','b-amber'],
                            'anggota'       => ['bi-people-fill','Statistik Anggota','Data anggota','b-green'],
                        ];
                        @endphp
                        @foreach($types as $val => [$icon,$label,$desc,$badge])
                        <label style="cursor:pointer;">
                            <input type="radio" name="jenis" value="{{ $val }}" style="display:none;" onchange="selectType(this)">
                            <div class="card" id="type-{{ $val }}" style="padding:14px;border:1.5px solid #e2e8f0;transition:all .15s;border-radius:10px;">
                                <div class="flex items-center gap-2 mb-1">
                                    <i class="bi {{ $icon }}" style="font-size:14px;"></i>
                                    <span class="font-sem" style="font-size:13px;">{{ $label }}</span>
                                </div>
                                <div class="text-xs text-muted">{{ $desc }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="grid g2 mb-3" style="gap:12px;margin-top:16px;">
                    <div class="fg">
                        <label class="lbl">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" class="input"
                            value="{{ now()->startOfMonth()->toDateString() }}" required>
                    </div>
                    <div class="fg">
                        <label class="lbl">Tanggal Akhir <span class="req">*</span></label>
                        <input type="date" name="tanggal_akhir" class="input"
                            value="{{ now()->toDateString() }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">
                    <i class="bi bi-play-fill"></i> Generate Laporan
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function selectType(radio) {
    document.querySelectorAll('[id^="type-"]').forEach(el => {
        el.style.borderColor = '#e2e8f0';
        el.style.background = '';
        el.style.boxShadow = '';
    });
    const el = document.getElementById('type-' + radio.value);
    el.style.borderColor = '#6366f1';
    el.style.background = '#f5f3ff';
    el.style.boxShadow = '0 0 0 3px rgba(99,102,241,.1)';
}
</script>
@endpush
@endsection
