@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Lokasi Kos</h3>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('lokasi_kos.index') }}" method="get" id="search-form">
                <div class="input-group">
                    {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('lokasi_kos.create')
            <!-- Include the modal partial -->
        </div>
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi Kos</th>
                    <th>Jumlah Kamar</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = $data->firstItem();
                @endphp
                @forelse ($data as $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->nama_kos }}</td>
                    <td>{{ $item->jumlah_kamar }}</td>
                    <td>{{ $item->alamat_kos }}</td>
                    <td>
                        <button class="btn btn-sm" style="background-color: #eb6a6a;margin-left: 10px" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="fas fa-trash" style="color: white"></i>
                                </button>
                        @include('lokasi_kos.delete')
                        <a href="{{ route('lokasi_kos.detail', $item->id) }}" class="btn btn-primary btn-sm"> 
                            <i class="fas fa-info-circle" style="color: white"></i></a>
                    </td>
                </tr>
                @php
                $i++;
                @endphp
                @empty
                <tr>
                    <td colspan="5">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $data->withQueryString()->links() }}
        </div>
    </div>


    <!-- LOKASI_KOS LIST TABLE -->
    

</div>


@endsection
