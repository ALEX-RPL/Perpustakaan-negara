{{-- Shared Reject Modal Component --}}
<div class="modal-bg" id="rejectModal">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-title">Tolak Peminjaman</div>
            <button class="modal-close-btn" onclick="document.getElementById('rejectModal').classList.remove('open')">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <p class="text-sm text-muted mb-3">Berikan alasan penolakan yang jelas untuk peminjam.</p>
                <div class="fg">
                    <label class="lbl">Alasan Penolakan <span class="req">*</span></label>
                    <textarea name="catatan" class="textarea" rows="3" required
                        placeholder="Contoh: Stok buku sedang dalam perbaikan..."></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('rejectModal').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-red"><i class="bi bi-x-circle"></i> Tolak Peminjaman</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openReject(id, prefix) {
    const routes = {
        admin: '/admin/peminjaman/' + id + '/reject',
        petugas: '/petugas/peminjaman/' + id + '/reject',
    };
    document.getElementById('rejectForm').action = routes[prefix] || routes.admin;
    document.getElementById('rejectModal').classList.add('open');
}
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
</script>
@endpush
