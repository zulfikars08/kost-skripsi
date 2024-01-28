<!-- transaksi.filter.blade.php -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pengeluaran.index') }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="filterNamaKos">Nama Kos</label>
                        <select class="form-control" id="filterNamaKos" name="nama_kos">
                            <option value="">Pilih Lokasi Kos</option>
                            @foreach ($lokasiKos as $lokasiKosOption)
                            <option value="{{ $lokasiKosOption->nama_kos }}">{{ $lokasiKosOption->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterBulan">Bulan</label>
                        <select class="form-control" id="filterBulan" name="bulan">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $monthValue => $monthName)
                            <option value="{{ $monthValue }}">{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterTahun">Tahun</label>
                        <select class="form-control" id="filterTahun" name="tahun">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                            <!-- Add options for years -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterTipePembayaran">Tipe Pembayaran</label>
                        <select class="form-control" id="filterTipePembayaran" name="tipe_pembayaran">
                            <option value="">Pilih Tipe Pembayaran</option>
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non Tunai</option>
                        </select>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between mb-3">
                        <button type="reset" class="btn btn-secondary" style="margin-right: 5px">Reset Filter</button>
                        <button type="submit" class="btn btn-primary" id="filter-button">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filter-form');
        const namaKos = document.getElementById('filterNamaKos');
        const bulan = document.getElementById('filterBulan');
        const tahun = document.getElementById('filterTahun');
        const statusPembayaran = document.getElementById('filterStatusPembayaran');
        const tipePembayaran = document.getElementById('filterTipePembayaran');
        const resetButton = document.getElementById('reset-button');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting

            const queryParams = [];

            if (namaKos.value) {
                queryParams.push(`nama_kos=${namaKos.value}`);
            }
            if (bulan.value) {
                queryParams.push(`bulan=${bulan.value}`);
            }
            if (tahun.value) {
                queryParams.push(`tahun=${tahun.value}`);
            }
            if (tipePembayaran.value) {
                queryParams.push(`tipe_pembayaran=${tipePembayaran.value}`);
            }

            const url = "{{ route('transaksi.index') }}";
            window.location.href = url + (queryParams.length > 0 ? '?' + queryParams.join('&') : '');
        });
    });
</script>
