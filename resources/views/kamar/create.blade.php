<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Kamar</h5>
            </div>
            <form action="{{ route('kamar.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Your form for adding data goes here -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_kamar" class="form-label">No Kamar</label>
                        <input type="text" class="form-control @error('no_kamar') is-invalid @enderror" name="no_kamar" id="no_kamar" value="{{ old('no_kamar') }}" required>
                        @error('no_kamar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="{{ old('fasilitas') }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="belum terisi" @if(old('status') === 'belum terisi') selected @endif>Belum Terisi</option>
                            <option value="sudah terisi" @if(old('status') === 'sudah terisi') selected @endif>Sudah Terisi</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Tipe Kamar</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Lokasi Kos</label>
                        <select class="form-control" name="lokasi_id" id="lokasi_id" required>
                            <option value="">Pilih Lokasi Kos</option>
                            @foreach ($lokasiKosOptions as $lokasiKosOption)
                                <option value="{{ $lokasiKosOption->id }}">{{ $lokasiKosOption->nama_kos }}</option>
                            @endforeach
                        </select>
                        @if (!$lokasiKosOptions->count())
                            <small class="text-danger">Lokasi Kos tidak tersedia. Harap tambahkan lokasi kos terlebih dahulu.</small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" onclick="showSuccessToast()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
