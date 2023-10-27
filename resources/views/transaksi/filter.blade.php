<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Filter Inputs for Lokasi Kos, Tanggal, and Status Pembayaran -->
                <form action="{{ route('transaksi.index') }}" method="GET" id="filter-form">
                    <div class="form-group">
                        <label for="nama_kos">Name of Kos:</label>
                        <select name="nama_kos" id="nama_kos" class="form-control">
                            <option value="">Select Kos</option>
                            @foreach ($lokasiKosData as $kos)
                                <option value="{{ $kos->id }}">{{ $kos->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Month:</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Select Month</option>
                            @foreach ($months as $key => $month)
                                <option value="{{ $key }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Year:</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_pembayaran">Status Pembayaran:</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                            @foreach ( $transaksidt as $option)
                            <option value="{{ $option->status_pembayaran }}">{{ $option->status_pembayaran }}</option>
                             @endforeach
                            <!-- Add options based on your data -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>                
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filter-form');
        const namaKos = document.getElementById('nama_kos');
        const bulan = document.getElementById('bulan');
        const tahun = document.getElementById('tahun');
        const statusPembayaran = document.getElementById('status_pembayaran');

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
            if (statusPembayaran.value) {
                queryParams.push(`status_pembayaran=${statusPembayaran.value}`);
            }

            const url = "/transaksi";
            window.location.href = url + (queryParams.length > 0 ? '?' + queryParams.join('&') : '');
        });
    });
</script>


