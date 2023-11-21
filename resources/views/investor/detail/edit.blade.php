<!-- Create/Edit Investor Modal -->
<div class="modal fade" id="editModal{{ $investor->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $investor->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Investor Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($investor) <!-- Check if $investor exists -->
            <form action="{{ route('investor.update', ['id' => $investor->id]) }}" method="post">
                @csrf
                @method('PUT') <!-- Add this line to specify that it's an update request -->

                <div class="modal-body">
                    <input type="hidden" name="id" id="investor_id" value="{{ $investor->id }}">
                    <div class="mb-3 custom-form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $investor->nama }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_pintu">Jumlah Pintu:</label>
                        <input type="number" class="form-control" id="jumlah_pintu" name="jumlah_pintu" value="{{ $investor->jumlah_pintu }}" required>
                    </div>
                    {{-- <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Lokasi Kos</label>
                        <select class="form-control" name="lokasi_id" id="lokasi_id" required>
                            <option value="">Pilih Lokasi Kos</option>
                            @foreach ($lokasiKos as $lokasiKosOption)
                                <option value="{{ $lokasiKosOption->id }}">{{ $lokasiKosOption->nama_kos }}</option>
                            @endforeach
                        </select>
                        @if (!$lokasiKosOptions->count())
                            <small class="text-danger">Lokasi Kos tidak tersedia. Harap tambahkan lokasi kos terlebih dahulu.</small>
                        @endif
                    </div> --}}
                    <div class="mb-3 custom-form-group">
                        <label for="filterBulan">Bulan</label>
                        <select class="form-control" id="filterBulan" name="bulan">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $monthValue => $monthName)
                                <option value="{{ $monthValue }}" {{ $investor->bulan == $monthValue ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="filterTahun">Tahun</label>
                        <select class="form-control" id="filterTahun" name="tahun">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $investor->tahun == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
