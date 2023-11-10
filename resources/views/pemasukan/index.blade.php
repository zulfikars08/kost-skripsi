<!-- resources/views/pemasukan/index.blade.php -->

@extends('layout.template')

@section('content')
<div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataPemasukanModal">
        Tambah data pemasukan
    </button>
    @include('pemasukan.create')

    <table class="table">
        <thead>
            <tr>
                <th>Kode Pemasukan</th>
                <th>No Kamar</th>
                <th>Nama Kos</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemasukan as $item)
                <tr>
                    <td>{{ $item->kode_pengeluaran }}</td>
                    <td>{{ $item->kamar->no_kamar }}</td>
                    <td>{{ $item->lokasiKos->nama_kos }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="fas fa-edit" style="color: white"></i>
                        </button>
                        @include('pemasukan.edit')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Includes --}}
</div>
@endsection
