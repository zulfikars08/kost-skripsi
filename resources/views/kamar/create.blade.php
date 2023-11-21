<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Kamar</h5>
            </div>
            <form action="{{ route('kamar.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Left column for labels -->
                            {{-- <div class="mb-3 custom-form-group">
                                <label for="nama_investor" class="form-label">Nama Investor</label>
                                <input type="text" class="form-control" name="nama_investor" id="nama_investor" value="{{ old('nama_investor') }}" required>
                            </div> --}}
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
                                <input type="text" class="form-control" name="harga" id="harga" oninput="formatAndSetIntegerValue(this)" required>
                            </div>
                            <div class="mb-3 custom-form-group">
                                <input type="hidden" name="harga" id="hargaInteger">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Right column for input fields -->
                            <div class="mb-3 custom-form-group">
                                <label class="form-label">Fasilitas</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fasilitas[]" id="ac" value="AC">
                                    <label class="form-check-label" for="ac">AC</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fasilitas[]" id="lemari" value="Lemari">
                                    <label class="form-check-label" for="lemari">Lemari</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fasilitas[]" id="kasur" value="Kasur">
                                    <label class="form-check-label" for="kasur">Kasur</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fasilitas[]" id="tv" value="TV">
                                    <label class="form-check-label" for="tv">TV</label>
                                </div>
                            </div>
                            <div class="mb-3 custom-form-group">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="Belum Terisi" @if(old('status') === 'Belum Terisi') selected @endif>Belum Terisi</option>
                                    <option value="Sudah Terisi" @if(old('status') === 'Sudah Terisi') selected @endif>Sudah Terisi</option>
                                </select>
                            </div>
                            <div class="mb-3 custom-form-group">
                                <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                                <select class="form-control" name="tipe_kamar" id="tipe_kamar" required>
                                    <option value="AC" @if(old('tipe_kamar') === 'AC') selected @endif>AC</option>
                                    <option value="Non AC" @if(old('tipe_kamar') === 'Non AC') selected @endif>Non AC</option>
                                </select>
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
