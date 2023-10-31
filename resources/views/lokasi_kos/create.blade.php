<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Lokasi Kos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('lokasi_kos.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Nama Kos -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama_kos" class="form-label">Nama Kos</label>
                        <input type="text" class="form-control" name="nama_kos" id="nama_kos" value="{{ old('nama_kos') }}" required>
                        @error('nama_kos')
                            <div class="text-danger">Nama Kos sudah digunakan</div>
                        @enderror
                    </div>
                    <!-- Jumlah Kamar -->
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                        <input type="text" class="form-control" name="jumlah_kamar" id="jumlah_kamar" value="{{ old('jumlah_kamar') }}" required>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="mb-3 custom-form-group">
                        <label for="alamat_kos" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat_kos" id="alamat_kos" value="{{ old('alamat_kos') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="showSuccessToast()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
