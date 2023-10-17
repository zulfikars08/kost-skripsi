@extends('layout.template')

@section('content')
<div class="container mt-5">
    <h3 class="text-start" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color: #333;">Dashboard</h3>
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-primary text-white order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Kamar Yang Tersedia</h6>
                    <h2 class="text-right"><i class="fas fa-bed"></i><span class="ml-2">{{ $totalKamar }}</span></h2>
                    <p class="m-b-0">Kamar Terisi</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-success text-white order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Lokasi Kos</h6>
                    <h2 class="text-right"><i class="fas fa-map-marked-alt"></i><span class="ml-2">{{ $totalLokasiKos }}</span></h2>
                    <p class="m-b-0">Lokasi Kos</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-warning order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Penyewa</h6>
                    <h2 class="text-right"><i class="fas fa-users"></i><span class="ml-2">{{ $totalPenyewa }}</span></h2>
                    <p class="m-b-0">Penyewa</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-3">
            <div class="card bg-warning order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Transaksi</h6>
                    <h2 class="text-right"><i class="fas fa-money-bill-wave"></i><span class="ml-2">{{ $totalTransaksi }}</span></h2>
                    <p class="m-b-0">Transaksi</p>
                </div>
            </div>
        </div>

        <!-- Add more cards here if needed -->

    </div>
</div>

<!-- Graph Section -->

<script>
    // ... your Chart.js code ...
</script>
@endsection
