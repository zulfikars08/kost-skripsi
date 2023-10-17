@extends('layout.template')

@section('content')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">List of Lokasi Kos</h3>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
        <form class="d-flex" action="{{ route('tanggal-transaksi.lokasi') }}" method="GET" id="search-form">
            <div class="input-group">
                <input type="text" class="form-control" name="katakunci" placeholder="Masukkan kata kunci" aria-label="Search" aria-describedby="basic-addon1" id="search-input">
                <button class="btn btn-secondary" type="submit">Cari</button>
            </div>
        </form>
    </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi Kos</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 1;
                @endphp
                @foreach ($lokasiKosData as $lokasiKos)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $lokasiKos->nama_kos }}</td>
                    <td>
                        <a href="{{ route('tanggal-transaksi.index', ['lokasi_id' => $lokasiKos->id]) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                        </a>
                    </td>
                </tr>
                @php
                $i++;
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
