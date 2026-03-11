@extends('layouts.app')
@section('title', isset($buku) ? 'Edit Buku' : 'Tambah Buku')
@section('page-title', isset($buku) ? 'Edit Buku' : 'Tambah Buku Baru')
@section('content')
@php
$prefix = auth()->user()->isAdministrator() ? 'admin' : 'petugas';
$action = isset($buku) ? route($prefix.'.buku.update',$buku->id) : route($prefix.'.buku.store');
@endphp

<div class="flex gap-4" style="align-items:flex-start;flex-wrap:wrap;">
    <div style="flex:1;min-width:0;min-width:300px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="bi bi-{{ isset($buku) ? 'pencil' : 'plus-circle' }}" style="color:#6366f1;"></i>
                    {{ isset($buku) ? 'Edit Data Buku' : 'Tambah Buku Baru' }}
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
                    @csrf @if(isset($buku)) @method('PUT') @endif

                    <div class="grid g2" style="gap:14px;margin-bottom:14px;">
                        <div class="fg" style="grid-column:1/-1;">
                            <label class="lbl">Judul Buku <span class="req">*</span></label>
                            <input type="text" name="judul" class="input {{ $errors->has('judul')?'invalid':'' }}"
                                value="{{ old('judul',$buku->judul??'') }}" placeholder="Masukkan judul lengkap..." required>
                            @error('judul') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg">
                            <label class="lbl">Pengarang <span class="req">*</span></label>
                            <input type="text" name="pengarang" class="input" value="{{ old('pengarang',$buku->pengarang??'') }}" required>
                            @error('pengarang') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg">
                            <label class="lbl">Penerbit <span class="req">*</span></label>
                            <input type="text" name="penerbit" class="input" value="{{ old('penerbit',$buku->penerbit??'') }}" required>
                            @error('penerbit') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg">
                            <label class="lbl">Tahun Terbit <span class="req">*</span></label>
                            <input type="number" name="tahun_terbit" class="input"
                                value="{{ old('tahun_terbit',$buku->tahun_terbit??date('Y')) }}"
                                min="1900" max="{{ date('Y') }}" required>
                            @error('tahun_terbit') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg">
                            <label class="lbl">ISBN</label>
                            <input type="text" name="isbn" class="input" value="{{ old('isbn',$buku->isbn??'') }}" placeholder="978-xxx-xxx-xxx">
                            @error('isbn') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg">
                            <label class="lbl">Kategori <span class="req">*</span></label>
                            <input type="text" name="kategori" class="input" value="{{ old('kategori',$buku->kategori??'') }}"
                                list="katList" placeholder="Fiksi, Teknologi..." required>
                            <datalist id="katList">
                                <option>Fiksi</option><option>Non-Fiksi</option><option>Sains</option>
                                <option>Teknologi</option><option>Sejarah</option><option>Biografi</option>
                                <option>Pendidikan</option><option>Agama</option><option>Ekonomi</option>
                            </datalist>
                            @error('kategori') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg">
                            <label class="lbl">Stok <span class="req">*</span></label>
                            <input type="number" name="stok" class="input" value="{{ old('stok',$buku->stok??1) }}" min="0" required>
                            @error('stok') <div class="err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fg" style="grid-column:1/-1;">
                            <label class="lbl">Deskripsi</label>
                            <textarea name="deskripsi" class="textarea" rows="3" placeholder="Sinopsis atau deskripsi singkat...">{{ old('deskripsi',$buku->deskripsi??'') }}</textarea>
                        </div>
                        <div class="fg">
                            <label class="lbl">Cover Buku</label>
                            <input type="file" name="cover" class="input" accept="image/*" id="coverInput" onchange="previewCover(event)">
                            <p class="hint">JPG/PNG, maks 2MB</p>
                        </div>
                        @if(isset($buku))
                        <div class="fg">
                            <label class="lbl">Status</label>
                            <select name="is_active" class="select">
                                <option value="1" {{ ($buku->is_active??true)?'selected':'' }}>Aktif</option>
                                <option value="0" {{ !($buku->is_active??true)?'selected':'' }}>Nonaktif</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ isset($buku) ? 'Update Buku' : 'Simpan Buku' }}
                        </button>
                        <a href="{{ route($prefix.'.buku.index') }}" class="btn btn-ghost">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Preview panel --}}
    <div style="width:220px;flex-shrink:0;" class="hide-mob">
        <div class="card">
            <div class="card-header"><div class="card-title">Preview</div></div>
            <div class="card-body" style="text-align:center;">
                <div id="coverPreview" style="width:100%;height:160px;border-radius:10px;background:linear-gradient(135deg,#eef2ff,#e0e7ff);display:flex;align-items:center;justify-content:center;margin-bottom:12px;overflow:hidden;">
                    @if(isset($buku) && $buku->cover)
                        <img src="{{ Storage::url($buku->cover) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <i class="bi bi-book" style="font-size:32px;color:#a5b4fc;"></i>
                    @endif
                </div>
                <div class="text-sm font-sem" id="previewTitle">{{ isset($buku) ? $buku->judul : 'Judul Buku' }}</div>
                <div class="text-xs text-muted mt-1" id="previewAuthor">{{ isset($buku) ? $buku->pengarang : 'Pengarang' }}</div>
            </div>
        </div>

        @if(isset($buku))
        <div class="card mt-4">
            <div class="card-body" style="padding:14px;">
                <div class="text-xs text-muted mb-2">Info Stok</div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm">Total</span>
                    <span class="font-sem">{{ $buku->stok }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm">Tersedia</span>
                    <span class="badge b-{{ $buku->stok_tersedia>0?'green':'red' }}">{{ $buku->stok_tersedia }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm">Dipinjam</span>
                    <span class="badge b-blue">{{ $buku->stok - $buku->stok_tersedia }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function previewCover(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('coverPreview').innerHTML =
            `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
}
document.querySelector('[name="judul"]')?.addEventListener('input', e => {
    const el = document.getElementById('previewTitle');
    if (el) el.textContent = e.target.value || 'Judul Buku';
});
document.querySelector('[name="pengarang"]')?.addEventListener('input', e => {
    const el = document.getElementById('previewAuthor');
    if (el) el.textContent = e.target.value || 'Pengarang';
});
</script>
@endpush
@endsection
