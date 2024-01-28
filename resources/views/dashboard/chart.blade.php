<div class="row">
    <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
        <div class="row align-items-end">
            {{-- Slicer for nama kos --}}
            <div class="col">
                <div class= "mb-3 custom-form-group">
                    <b><label for="nama_kos" class="form-label">Nama Kos:</label></b>
                    <select name="nama_kos" id="nama_kos" class="form-select">
                        <option value="">Pilih Lokasi Kos</option>
                        @foreach($namaKosList as $kos)
                        <option value="{{ $kos }}" {{ $selectedNamaKos==$kos ? 'selected' : '' }}>{{ $kos }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Slicer for bulan --}}
            <div class="col">
                <div class="mb-3 custom-form-group">
                    <b><label for="bulan" class="form-label">Bulan:</label></b>
                    <select name="bulan" id="bulan" class="form-select">
                        @foreach($bulanList as $bulan)
                        <option value="{{ $bulan }}" {{ $selectedBulan==$bulan ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $bulan, 10)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Slicer for tahun --}}
            <div class="col">
                <div class="mb-3 custom-form-group">
                    <b><label for="tahun" class="form-label">Tahun:</label></b>
                <select name="tahun" id="tahun" class="form-select">
                    @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ $selectedTahun==$tahun ? 'selected' : '' }}>{{ $tahun }}
                    </option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="mb-3 custom-form-group">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button class="btn btn-secondary" type="submit" style="margin-left: 5px">Reset Filter</button>
                </div>
            </div>
        </div>
    </form>

    @if($filtersApplied)
    @if(!empty($netIncomeResults))
    <div class="row">
        <div class="mb-3 custom-form-group">
            @foreach($netIncomeResults as $result)
            <p><b>Pendapatan Bersih:</b> <button class="btn btn-success"> {{
                "Rp " . number_format($result['net_income'], 2) }}</button></p>
            @endforeach
        </div>
    </div>
    @endif
    @endif
</div>
<canvas id="myChart" width="300" height="35"></canvas>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('myChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['days']),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($chartData['pemasukanData']),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($chartData['pengeluaranData']),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>