@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <div class="mb-3 text-start">
        <a href="{{ url('lokasi') }}" class="btn btn-secondary mb-3 s">Kembali</a>
    </div>
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Tanggal Transaksi</h3>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('tanggal-transaksi.index') }}" method="get" id="search-form">
                <div class="input-group">
                    {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                    <input class="form-control" type="search" name="search" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>
            

           <!-- resources/views/tanggal-transaksi/index.blade.php -->

<!-- Add this button or link to open the create modal -->
        {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTanggalTransaksiModal">
        Tambah Tanggal Transaksi
        </button>

            @include('tanggal-transaksi.create') --}}
            <!-- Include the modal partial -->
        </div>
    </div>
    <!-- TANGGAL TRANSAKSI LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 1;
            @endphp
            @foreach ($tanggalTransaksi as $tanggalTransaksi)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $tanggalTransaksi->bulan }}</td>       
                <td>{{ $tanggalTransaksi->tahun }}</td>
                <td >
                    <a href="{{ route('tanggal-transaksi.detail', ['id' => $tanggalTransaksi->id]) }}" class="btn btn-primary btn-sm"> 
                        <i class="fas fa-info-circle" style="color: white"></i>
                    </a>                   
                    <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                        action="{{ route('tanggal-transaksi.destroy', $tanggalTransaksi->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash" style="color: white"></i> <!-- Delete Icon -->
                        </button>
                    </form>
                </td>
            </tr>
            @php
            $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination Links -->
    {{-- {{ $tanggalTransaksis->appends(request()->query())->links() }} --}}
</div>
@endsection
