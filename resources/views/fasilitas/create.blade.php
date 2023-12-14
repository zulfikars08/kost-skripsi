<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('fasilitas.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Nama Kos -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama_fasilitas" class="form-label">Nama Fasilitas</label>
                        <input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" value="{{ old('nama_fasilitas') }}" required>
                        @error('nama_fasilitas')
                            <div class="text-danger">Nama Kos sudah digunakan</div>
                        @enderror
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="showSuccessToast()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
