<!-- Create/Edit Investor Modal -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Investor Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('investor.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="investor_id">
                    <div class="mb-3 custom-form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_pintu">Jumlah Pintu:</label>
                        <input type="number" class="form-control" id="jumlah_pintu" name="jumlah_pintu" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id">Lokasi Kos:</label>
                        <select class="form-control" id="lokasi_id" name="lokasi_id" required>
                            <option value="">Select a Location</option>
                            @foreach($lokasiKos as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_kos }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="filterBulan">Bulan</label>
                        <select class="form-control" id="filterBulan" name="bulan">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $monthValue => $monthName)
                            <option value="{{ $monthValue }}">{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="filterTahun">Tahun</label>
                        <select class="form-control" id="filterTahun" name="tahun">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option> <!-- Use the four-digit year format -->
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
