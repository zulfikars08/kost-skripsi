@extends('layout.template')

@section('content')
<div class="container-fluid" style="max-height: 800px;">
    <h3 class="text-start"
        style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color: #333;">
        Dashboard</h3>
    {{-- <div class="my-3 p-3 bg-body rounded shadow-sm"> --}}
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card bg-success text-white order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Lokasi Kos</h6>
                        <h2 class="text-right"><i class="fas fa-map-marked-alt" style="margin-right: 10px;"></i><span class="ml-2">{{
                                $totalLokasiKos }}</span></h2>
                        <p class="m-b-0">Lokasi Kos</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-primary text-white order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Kamar Yang Tersedia</h6>
                        <h2 class="text-right"><i class="fas fa-bed" style="margin-right: 10px;"></i><span class="ml-2">{{ $totalKamar }}</span>
                        </h2>
                        <p class="m-b-0">Kamar Terisi</p>
                    </div>
                </div>
            </div>


            {{-- <div class="col-md-4 col-xl-3">
                <div class="card bg-warning order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Penyewa</h6>
                        <h2 class="text-right"><i class="fas fa-users"></i><span class="ml-2">{{ $totalPenyewa }}</span>
                        </h2>
                        <p class="m-b-0">Penyewa</p>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-4 col-xl-3">
                <div class="card bg-primary order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Penyewa Aktif</h6>
                        <h2 class="text-right"><i class="fas fa-users" style="margin-right: 10px;"></i><span class="ml-2">{{ $totalPenyewaAktif
                                }}</span></h2>
                        <p class="m-b-0">Penyewa Aktif</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-warning order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Transaksi</h6>
                        <h2 class="text-right"><i class="fas fa-money-bill-wave" style="margin-right: 10px;"></i><span class="ml-2">{{
                                $totalTransaksi }}</span></h2>
                        <p class="m-b-0">Transaksi</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <!-- Pemasukan card -->
                <div class="card bg-info text-white order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Pemasukan</h6>
                        <h2 class="text-right"><i class="fas fa-arrow-up" style="margin-right: 10px;"></i><span class="ml-2">{{ $totalPemasukan
                                }}</span></h2>
                        <p class="m-b-0">Pemasukan</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <!-- Pengeluaran card -->
                <div class="card bg-danger text-white order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Pengeluaran</h6>
                        <h2 class="text-right"><i class="fas fa-arrow-down" style="margin-right: 10px;"></i><span class="ml-2">{{ $totalPengeluaran
                                }}</span></h2>
                        <p class="m-b-0">Pengeluaran</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <!-- Pendapatan Bersih card -->
                <div class="card bg-secondary order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Pendapatan Bersih</h6>
                        <h2 class="text-right"><i class="fas fa-chart-line" style="margin-right: 10px;"></i><span class="ml-2">{{ $pendapatanBersih
                                }}</span></h2>
                        <p class="m-b-0">Pendapatan Bersih</p>
                    </div>
                </div>
            </div>
            <!-- Add the following card to your existing dashboard.blade.php file -->
            <div class="col-md-4 col-xl-3">
                <div class="card bg-info order-card mb-4">
                    <div class="card-body">
                        <h6 class="m-b-20">Total Investor</h6>
                        <h2 class="text-right"><i class="fas fa-users" style="margin-right: 10px;"></i><span class="ml-2">{{ $totalInvestor
                                }}</span></h2>
                        <p class="m-b-0">Investor</p>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.chart')
    </div>
    @endsection