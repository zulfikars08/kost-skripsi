@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Kamar</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm" >
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('kamar.index') }}" method="get" id="search-form">
                <div class="input-group">
                    {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci" aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('kamar.create')

            <!-- Include the modal partial -->



        </div>
    </div>



    <!-- ROOMS LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No Kamar</th>
                <th>Harga</th>
                <th>Fasilitas</th>
                <th>Keterangan</th>
                <th>
                    <!-- Filter by Lokasi Kos dropdown here -->
                    <div class="dropdown">
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="lokasiDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lokasi Kos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="lokasiDropdown">
                            <form action="{{ route('kamar.index') }}" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="filter_by_lokasi" id="lokasiKos">
                                        <option value="">Semua Lokasi Kos</option>
                                        @foreach ($lokasiKosOptions as $lokasiKosOption)
                                        <option value="{{ $lokasiKosOption->nama_kos }}">{{ $lokasiKosOption->nama_kos }}</option>
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
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="statusDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Status
                        </a>
                        <div class="dropdown-menu" aria-labelledby="statusDropdown">
                            <form action="{{ route('kamar.index') }}" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="filter_by_status" id="filterByStatus">
                                        <option value="">Semua Status</option>
                                        <option value="belum terisi" {{ request('filter_by_status')==='belum terisi' ? 'selected' : '' }}>Belum Terisi</option>
                                        <option value="sudah terisi" {{ request('filter_by_status')==='sudah terisi' ? 'selected' : '' }}>Sudah Terisi</option>
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
                <td>{{ ($filteredKamarData->currentPage() - 1) * $filteredKamarData->perPage() + $loop->iteration }}</td>
                <td>{{ $item->no_kamar }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->fasilitas }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->lokasiKos->nama_kos }}</td>
                <td>
                    @if ($item->status === 'belum terisi' || $item->status == NULL)
                    <button class="btn btn-status btn-danger">{{ $item->status }}</button>
                    @else
                    <button class="btn btn-status btn-success">{{ $item->status }}</button>
                    @endif
                </td>
                <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}">
                            <i class="fas fa-edit" style="color: white"></i> <!-- Edit Icon -->
                        </button>
                        @include('kamar.edit', ['item' => $item])
                        <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                            action="{{ route('kamar.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit" class="btn btn-danger btn-sm"  onclick="showSuccessToast()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
@endsection