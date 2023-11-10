<!-- resources/views/pengeluaran/index.blade.php -->

@extends('layout.template')

@section('content')
<div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataPengeluaranModal">
        Tambah data pengeluaran
    </button>
    @include('pengeluaran.create')
    <table class="table">
        <thead>
            <tr>
                <th>Kode Pengeluaran</th>
                <th>No Kamar</th>
                <th>Nama Kos</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Actions</th>
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
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPengeluaranModal{{ $item->id }}">
                            Edit
                        </button>
                    </td>
                </tr>
                {{-- @include('pengeluaran.edit_modal', ['pengeluaran' => $item]) --}}
            @endforeach
        </tbody>
    </table>
</div>


@endsection
