@extends('layout.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="mb-3 text-start">
                <a href="{{ url('penyewa') }}" class="btn btn-secondary mb-3 s">Kembali</a>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white text-start">
                    <h4 class="mb-0">Detail Penyewa</h4>
                </div>

                <div class="card-body p-4"> <!-- Added "p-4" class for padding -->
                    @foreach ($penyewaList as $item)
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-info text-white">Nama Penyewa</th>
                                <td>{{ $item->nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">No Kamar</th>
                                <td>{{ $item->no_kamar }}</td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">Status Penyewa</th>
                                <td>
                                    @if ($item->status_penyewa === 'aktif')
                                    <button class="btn btn-success btn-sm">Aktif</button>
                                    @else
                                    <button class="btn btn-danger btn-sm">Tidak Aktif</button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">Nama Kos</th>
                                <td>
                                    @if ($item->lokasi_id)
                                        <?php
                                        $lokasiKos = \App\Models\LokasiKos::find($item->lokasi_id);
                                        ?>
                                        @if ($lokasiKos)
                                            {{ $lokasiKos->nama_kos }}
                                        @else
                                            No Lokasi Kos
                                        @endif
                                    @else
                                        No Kamar
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endforeach

                    <div class="d-flex justify-content-between align-items-left pb-3">
                        <h5 class="mt-4">Daftar Penghuni</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-left pb-3">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>
                        @include('penyewa.penghuni.create')
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Penghuni</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>No Hp</th>
                                <th>Pekerjaan</th>
                                <th>Perusahaan</th>
                                <th>Martial Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penghuni as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->tanggal_lahir }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>{{ $item->pekerjaan }}</td>
                                    <td>{{ $item->perusahaan }}</td>
                                    <td>{{ $item->martial_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
