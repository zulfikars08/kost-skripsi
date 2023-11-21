<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kamar.update', $item->id) }}" method="post">
                @csrf
                @method('PUT') <!-- Use the PUT method for updates -->

                <div class="modal-body">
                    <!-- Your form fields for editing -->
                    <div class="mb-3 custom-form-group">
                        <label for="modalHarga" class="form-label">Harga</label>
                        <input type="text" class="form-control" name="harga" id="modalHarga" value="{{ number_format($item->harga, 0, ',', ',') }}" oninput="formatAndSetDecimalValue(this, 'modalHargaDecimal')" required>
                        <input type="hidden" name="modalHargaDecimal" id="modalHargaDecimal" value="{{ $item->harga }}">
                        <input type="hidden" name="modalHarga" id="modalHarga" value="{{ $item->harga }}">                        
                    </div>
                    {{-- <div class="mb-3 custom-form-group">
                        <input type="hidden" name="modalHargaDecimal" id="modalHargaDecimal">
                    </div> --}}
                    <div class="mb-3 custom-form-group">
                        <label class="form-label">Fasilitas</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fasilitas[]" id="ac" value="AC" {{ in_array('AC', explode(',', $item->fasilitas)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ac">AC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fasilitas[]" id="lemari" value="Lemari" {{ in_array('Lemari', explode(',', $item->fasilitas)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lemari">Lemari</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fasilitas[]" id="kasur" value="Kasur" {{ in_array('Kasur', explode(',', $item->fasilitas)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kasur">Kasur</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fasilitas[]" id="tv" value="TV" {{ in_array('TV', explode(',', $item->fasilitas)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tv">TV</label>
                        </div>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="belum terisi" {{ $item->status === 'belum terisi' ? 'selected' : '' }}>Belum Terisi</option>
                            <option value="sudah terisi" {{ $item->status === 'sudah terisi' ? 'selected' : '' }}>Sudah Terisi</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Tipe Kamar</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ $item->keterangan }}" required>
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
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
