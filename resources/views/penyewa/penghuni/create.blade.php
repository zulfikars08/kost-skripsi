<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Penyewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="myForm" action="{{ route('penyewa.detail.store', ['id' => request()->route('id')]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Select Penyewa -->
                    <div class="mb-3 custom-form-group">
                        <label for="penyewa_id" class="form-label text-start">Penyewa ID</label>
                        <input type="text" class="form-control" id="penyewa_id" value="{{ request()->route('id') }}" disabled>
                    </div>
                    <!-- Nama -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required>
                    </div>
                    <!-- Tanggal Lahir -->
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
                    </div>
                    <!-- Jenis Kelamin -->
                    <div class="mb-3 custom-form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <!-- No Telepon -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_hp" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{ old('no_telepon') }}" required>
                    </div>
                    <!-- Pekerjaan -->
                    <div class="mb-3 custom-form-group">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}">
                    </div>
                    <!-- Perusahaan -->
                    <div class="mb-3 custom-form-group">
                        <label for="perusahaan" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control" name="perusahaan" id="perusahaan" value="{{ old('perusahaan') }}">
                    </div>
                    <!-- Martial Status -->
                    <div class="mb-3 custom-form-group">
                        <label for="martial_status">Martial Status</label>
                        <select name="martial_status" id="martial_status">
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>