@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Kamar</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-secondary" type="submit">Reset Filter</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal" style="margin-left: 5px">
                Filter
            </button>
            @include('kamar.filter')
            </div>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal" style="margin-left: 5px">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('kamar.create')
            <!-- Include the modal partial -->
            
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">No</th>
                            <th style="white-space: nowrap;">No Kamar</th>
                            <th style="white-space: nowrap;">Harga</th>
                            <th style="white-space: nowrap;">Fasilitas</th>
                            {{-- <th>Tipe Kamar</th> --}}
                            <th>
                                <!-- Filter by Lokasi Kos dropdown here -->
                                <div class="dropdown">
                                    <a class="filter-icon dropdown-toggle" href="#" role="button" id="tipeKamarDropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Tipe Kamar
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="tipeKamarDropdown">
                                        <form action="{{ route('kamar.index') }}" method="get">
                                            <div class="form-group px-2">
                                                <select class="form-control" name="filter_by_tipe_kamar" id="filterByTipeKamar">
                                                    <option value="">Semua Status</option>
                                                    <option value="AC" {{ request('filter_by_tipe_kamar')==='AC' ? 'selected'
                                                        : '' }}>AC</option>
                                                    <option value="Non AC" {{ request('filter_by_tipe_kamar')==='Non AC'
                                                        ? 'selected' : '' }}>Non AC</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer px-2">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <!-- Filter by Lokasi Kos dropdown here -->
                                <div class="dropdown">
                                    <a class="filter-icon dropdown-toggle" href="#" role="button" id="lokasiDropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Lokasi Kos
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="lokasiDropdown">
                                        <form action="{{ route('kamar.index') }}" method="get">
                                            <div class="form-group px-2">
                                                <select class="form-control" name="filter_by_lokasi" id="lokasiKos">
                                                    <option value="">Semua Lokasi Kos</option>
                                                    @foreach ($lokasiKosOptions as $lokasiKosOption)
                                                    <option value="{{ $lokasiKosOption->nama_kos }}">{{
                                                        $lokasiKosOption->nama_kos }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer px-2">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </th>
                            <!-- Filter by Status dropdown here -->
                            <th>
                                <div class="dropdown">
                                    <a class="filter-icon dropdown-toggle" href="#" role="button" id="statusDropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Status
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                        <form action="{{ route('kamar.index') }}" method="get">
                                            <div class="form-group px-2">
                                                <select class="form-control" name="filter_by_status" id="filterByStatus">
                                                    <option value="">Semua Status</option>
                                                    <option value="Belum Terisi" {{ request('filter_by_status')==='Belum Terisi'
                                                        ? 'selected' : '' }}>Belum Terisi</option>
                                                    <option value="Sudah Terisi" {{ request('filter_by_status')==='Sudah Terisi'
                                                        ? 'selected' : '' }}>Sudah Terisi</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer px-2">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filteredKamarData as $key => $item)
                        <tr>
                            <td>{{ ($filteredKamarData->currentPage() - 1) * $filteredKamarData->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $item->no_kamar }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->fasilitas }}</td>
                            <td>{{ $item->tipe_kamar }}</td>
                            <td>{{ $item->lokasiKos->nama_kos }}</td>
                            <td>
                                @if ($item->status === 'Belum Terisi' || $item->status == NULL)
                                <button class="btn btn-status btn-danger">{{ $item->status }}</button>
                                @else
                                <button class="btn btn-status btn-success">{{ $item->status }}</button>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{$item->id}}">
                                    <i class="fas fa-edit" style="color: white"></i> <!-- Edit Icon -->
                                </button>
                                @include('kamar.edit', ['item' => $item])
                                <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $item->id }}" style="margin-left: 10px">
                                    <i class="fas fa-trash" style="color: white"></i>
                                </button>
                                @include('kamar.delete')
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $filteredKamarData->appends(request()->except('page'))->links() }}
                </div>

        </div>
        
    </div>
    @endsection