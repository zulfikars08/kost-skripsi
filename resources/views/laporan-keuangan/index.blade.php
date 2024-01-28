@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0;">Data Laporan Keuangan</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-end pb-3">
            <!-- SEARCH FORM -->
            {{-- <form class="d-flex" action="{{ route('laporan-keuangan.index') }}" method="get" id="search-form">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Cari Nama Kos, Bulan, Tahun"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form> --}}

            {{-- <button type="button" class="btn btn-secondary"  data-bs-toggle="modal" data-bs-target="#tambahDataModal" >
                <i class="fas fa-plus"></i> Tambah Tanggal
            </button>            
            @include('laporan-keuangan.create') --}}
              <button type="button" class="btn btn-success" data-bs-toggle="modal" style="margin-left:5px"
                data-bs-target="#generateReportModal">
                <i class="fas fa-file-excel"></i> Export to Excel
            </button>
            @include('laporan-keuangan.export')
        </div>

        <div class="table-responsive">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi Kos</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
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
                                ]) }}" class="btn btn-primary btn-sm" title="Detail">
                                     <i class="fas fa-info-circle" style="color: white"></i>
                                </a>
                                <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $item->id }}" style="margin-left: 10px" title="Delete">
                                <i class="fas fa-trash" style="color: white"></i>
                            </button>
                            @include('laporan-keuangan.delete')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tanggalLaporan->links() }}
        </div>
    </div>
</div>
@endsection