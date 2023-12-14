<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Tipe Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tipe_kamar.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Nama Kos -->
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                        <input type="text" class="form-control" name="tipe_kamar" id="tipe_kamar" value="{{ old('tipe_kamar') }}" required>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="showSuccessToast()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
