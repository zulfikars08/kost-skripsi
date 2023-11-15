<!-- resources/views/pengeluaran/index.blade.php -->

@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Pengeluaran</h3>

    
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

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataPengeluaranModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('pengeluaran.create')
            <!-- Include the modal partial -->
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Pengeluaran</th>
                    <th>No Kamar</th>
                    <th>Nama Kos</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($expenditures as $item)
                    <tr>
                        <td>{{ $item->kode_pengeluaran }}</td>
                        <td>{{ $item->kamar_id }}</td>
                        <td>{{ $item->lokasi_id }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->keterangan }}</td>
                        {{-- <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPengeluaranModal{{ $item->id }}">
                                Edit
                            </button>
                        </td> --}}
                    </tr>
                    {{-- @include('pengeluaran.edit_modal', ['pengeluaran' => $item]) --}}
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>


@endsection
