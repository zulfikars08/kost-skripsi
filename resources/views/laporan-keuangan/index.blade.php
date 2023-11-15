@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0;">Tanggal Laporan</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-end pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('laporan-keuangan.index') }}" method="get" id="search-form">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Cari Nama Kos, Bulan, Tahun"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <button type="button" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#tambahDataModal" >
                <i class="fas fa-plus"></i> Tambah Tanggal
            </button>            
            @include('laporan-keuangan.create')
        </div>

        <div class="table-responsive">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kos</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tanggalLaporan as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                               {{ $item->nama_kos
                            }}
                            </td>
                            <td>{{ date('F', mktime(0, 0, 0, $item->bulan, 1) ) }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>
                               <a href="{{ route('laporan-keuangan.detail.index', [
                                     'nama_kos' => $item->lokasi_id,
                                     'bulan' => $item->bulan,
                                    'tahun' => $item->tahun
                                ]) }}" class="btn btn-primary btn-sm">
                                     <i class="fas fa-info-circle" style="color: white"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection