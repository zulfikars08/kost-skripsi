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
                        <input type="text" class="form-control" name="harga" id="harga" value="{{ number_format($item->harga, 0, ',', '.') }}" oninput="formatAndSetDecimalValue(this, 'harga')" required>
                        <input type="hidden" name="harga" id="harga" value="{{ $item->harga }}">
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label class="form-label">Fasilitas</label>
                        @foreach ($fasilitasOptions as $fasilitasOption)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fasilitas[]"
                                    id="{{ $fasilitasOption->slug }}" value="{{ $fasilitasOption->id }}"
                                    {{ in_array($fasilitasOption->id, $item->fasilitas->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $fasilitasOption->slug }}">{{ $fasilitasOption->nama_fasilitas }}</label>
                            </div>
                        @endforeach
                        @if (!$fasilitasOptions->count())
                        <small class="text-danger">Fasilitas tidak tersedia. Harap tambahkan fasilitas terlebih dahulu.</small>
                    @endif
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_kamar_id" class="form-label">Tipe Kamar</label>
                        <select class="form-control" name="tipe_kamar_id" id="tipe_kamar_id" required>
                            <option value="">Pilih Tipe Kamar</option>
                            @foreach ($tipeKamarOptions as $tipeKamarOption)
                                <option value="{{ $tipeKamarOption->id }}" {{ $item->tipe_kamar_id === $tipeKamarOption->id ? 'selected' : '' }}>
                                    {{ $tipeKamarOption->tipe_kamar }}
                                </option>
                            @endforeach
                        </select>
                        @if (!$tipeKamarOptions->count())
                            <small class="text-danger">Tipe Kamar tidak tersedia. Harap tambahkan tipe kamar terlebih dahulu.</small>
                        @endif
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">Pilih Status Kamar</option>
                            <option value="Belum Terisi" @if(old('status')==='Belum Terisi' ) selected @endif>
                                Belum Terisi</option>
                            <option value="Sudah Terisi" @if(old('status')==='Sudah Terisi' ) selected @endif>
                                Sudah Terisi</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Lokasi Kos</label>
                        <select class="form-control" name="lokasi_id" id="lokasi_id" required>
                            @foreach ($lokasiKosOptions as $lokasiKosOption)
                                <option value="{{ $lokasiKosOption->id }}" {{ $item->lokasi_id === $lokasiKosOption->id ? 'selected' : '' }}>
                                    {{ $lokasiKosOption->nama_kos }}
                                </option>
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
