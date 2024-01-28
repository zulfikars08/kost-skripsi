<!-- transaksi.filter.blade.php -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('transaksi.index') }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 custom-form-group">
                        <label for="filterNamaKos">Lokasi Kos</label>
                        <select class="form-control" id="filterNamaKos" name="nama_kos">
                            <option value="">Pilih Lokasi Kos</option>
                            @foreach ($lokasiKosData as $lokasiKosOption)
                            <option value="{{ $lokasiKosOption->nama_kos }}">{{ $lokasiKosOption->nama_kos }}</option>
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
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                            <!-- Add options for years -->
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="filterStatusPembayaran">Status Pembayaran</label>
                        <select class="form-control" id="filterStatusPembayaran" name="status_pembayaran">
                            <option value="">Pilih Status Pembayaran</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Cicil">Cicil</option>
                            <option value="belum_lunas">Belum Lunas</option>
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
        
        // Handle the filter form submission
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting
            applyFilter();
        });
    
        // Handle the reset filter button click
        document.getElementById('reset-filter-button').addEventListener('click', function () {
            resetFilter();
        });
    });
    
    // Function to apply the filter
    function applyFilter() {
        const data = {
            nama_kos: document.getElementById('filterNamaKos').value,
            bulan: document.getElementById('filterBulan').value,
            tahun: document.getElementById('filterTahun').value,
            status_pembayaran: document.getElementById('filterStatusPembayaran').value
        };
    
        fetch("{{ route('transaksi.filter') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('search-results').innerHTML = html;
            $('#filterModal').modal('hide'); // Hide the modal after successful filtering
        });
    }
    
    // Function to reset the filter
    function resetFilter() {
        document.getElementById('filterNamaKos').value = '';
        document.getElementById('filterBulan').value = '';
        document.getElementById('filterTahun').value = '';
        document.getElementById('filterStatusPembayaran').value = '';
    
        // Optionally, refresh the data
        fetchLokasiData(); // Call this function if you want to refresh the data after resetting the filter
    }
    
    // Function to fetch location data
    function fetchLokasiData() {
        // Replace with your actual AJAX call to fetch and display the data
        console.log('Fetching data with default/no filters');
        // ...
    }
    </script>