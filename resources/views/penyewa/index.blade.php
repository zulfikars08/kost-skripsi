@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Penyewa</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('penyewa.index') }}" method="get" id="search-form">
                <div class="input-group">
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('penyewa.create')
            <!-- Include the modal partial -->
        </div>
        <!-- PENYEWA LIST TABLE -->
        <div class="table-responsive">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th> <!-- Add the ID column -->
                        <th>Nama</th>
                        <th>No Kamar</th>
                        <th>Lokasi Kos</th>
                        <th>Status Penyewa</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penyewas as $penyewa)
                    <tr>
                        <td>{{ $loop->index + 1 + $penyewas->perPage() * ($penyewas->currentPage() - 1) }}</td>
                        <td>{{ $penyewa->kode_penyewa }}</td> <!-- Display the ID -->
                        <td>{{ $penyewa->nama }}</td>
                        <td>{{ $penyewa->kamar->no_kamar }}</td>
                        <td>{{ $penyewa->lokasi->nama_kos }}</td>
                        <td>
                            @if ($penyewa->status_penyewa === 'aktif')
                            <button class="btn btn-success btn-sm">Aktif</button>
                            @else
                            <button class="btn btn-danger btn-sm">Tidak Aktif</button>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editStatusPenyewaModal{{ $penyewa->id }}">
                                <i class="fas fa-edit" style="color: white"></i>
                            </button>
                            @include('penyewa.edit')
                            <a href="{{ route('penyewa.show', $penyewa->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-info-circle" style="color: white"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $penyewas->withQueryString()->links() }}
        </div>
        
    </div>
</div>

@endsection