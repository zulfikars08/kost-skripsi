@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Laporan investor
    </h3>
    
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
        {{-- <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
            <i class="fas fa-plus"></i> Tambah Data Lokasi
        </button>
        @include('investor.create') --}}
        <button type="button" class="btn btn-success" style="margin-left: 3px" data-bs-toggle="modal"
        data-bs-target="#generateReportModals">
        <i class="fas fa-file-excel"></i> Export to Excel
    </button>
    @include('investor.export')
        </div>
        <!-- INVESTOR DETAIL TABLE (BASED ON nama_kos) -->
        <div class="table-responsive">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Lokasi Kos</th>
                        <th style="white-space: nowrap;">Bulan</th>
                        <th style="white-space: nowrap;">Tahun</th>
                        <th style="white-space: nowrap;">Jumlah Investor</th>
                        <th style="white-space: nowrap;">Aksi</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tanggalInvestor as $investor)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $investor->nama_kos }}</td>
                        <td>{{$investor->bulan}}</td>
                        <td>{{$investor->tahun}}</td>
                        <td>{{ $investor->jumlah_investor }}</td>
                        <td>
                            <a href="{{ route('investor.detail.index', [
                                  'lokasi_id' => $investor->lokasi_id,
                                 'bulan' => $investor->bulan,
                                 'tahun' => $investor->tahun
                             ]) }}" class="btn btn-primary btn-sm" title="Detail">
                                  <i class="fas fa-info-circle" style="color: white"></i>
                             </a>
                             <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                             data-bs-target="#deleteModal{{ $investor->id }}" style="margin-left: 10px" title="Delete">
                             <i class="fas fa-trash" style="color: white"></i>
                         </button>
                         @include('investor.delete')
                         </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">Tidak ada data investor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $investors->links()}}
        </div>
    </div>

@endsection
