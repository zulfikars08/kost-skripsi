<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Penyewa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  id="myForm" action="{{ route('penyewa.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Nama Kos (Kost name) Dropdown -->
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Nama Kos</label>
                        <select class="form-select" id="lokasi_id" name="lokasi_id" required>
                            <option value="" disabled selected>Select Nama Kos</option>
                            @foreach ($lokasiKos as $kos)
                                <option value="{{ $kos->id }}">{{ $kos->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No. Kamar (Room number) -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_kamar" class="form-label">No. Kamar</label>
                        <input type="text" class="form-control" name="no_kamar" id="no_kamar" value="{{ old('no_kamar') }}" required>
                        @error('no_kamar')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Nama -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status_penyewa">Edit Status Penyewa:</label>
                        <select name="status_penyewa" id="status_penyewa">
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <!-- Keterangan Pembayaran -->
                    {{-- <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan Pembayaran</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" required>
                    </div> --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" onclick="checkFormAndSubmit()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
