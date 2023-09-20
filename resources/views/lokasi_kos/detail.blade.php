@extends('layout.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="mb-3 text-start">
                <a href="{{ url('lokasi_kos') }}" class="btn btn-secondary mb-3 s">Kembali</a>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white text-start">
                    <h4 class="mb-0">Detail Lokasi</h4>
                </div>
                <div class="card-body p-4"> <!-- Added "p-4" class for padding -->
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-info text-white">Lokasi kos</th>
                            <td>{{ $lokasiKos->nama_kos }}</td>
                        </tr>
                        <tr>
                            <th class="bg-info text-white">Jumlah Kamar</th>
                            <td>{{ $lokasiKos->jumlah_kamar }}</td>
                        </tr>
                        <tr>
                            <th class="bg-info text-white">Alamat</th>
                            <td>{{ $lokasiKos->alamat_kos }}</td>
                        </tr>
                    </table>

                    <h5 class="mt-4">Daftar Kamar:</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Kamar</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $kamarNumbers = []; // Array to track displayed room numbers
                            @endphp
                    
                            @forelse ($lokasiKos->kamars as $kamar)
                                @if (!in_array($kamar->no_kamar, $kamarNumbers)) <!-- Check if room number is already displayed -->
                                    <tr>
                                        <td>{{ $kamar->no_kamar }}</td>
                                        <td>Rp{{ number_format($kamar->harga, 2) }}</td>
                                        <td>{{ $kamar->keterangan }}</td>
                                        <td>{{ $kamar->fasilitas }}</td>
                                    </tr>
                                    @php
                                        $kamarNumbers[] = $kamar->no_kamar; // Add room number to the array
                                    @endphp
                                @endif
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted">Tidak ada kamar tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
