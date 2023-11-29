@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Tanggal investor updet test 2 3 4 5 6 7 8 9 10
    </h3>
    
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
        {{-- <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
            <i class="fas fa-plus"></i> Tambah Data Lokasi
        </button>
        @include('investor.create') --}}
        </div>
        <!-- INVESTOR DETAIL TABLE (BASED ON nama_kos) -->
        <div class="table-responsive">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Nama Kos</th>
                        <th style="white-space: nowrap;">bulan</th>
                        <th style="white-space: nowrap;">tahun</th>
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
                             ]) }}" class="btn btn-primary btn-sm">
                                  <i class="fas fa-info-circle" style="color: white"></i>
                             </a>
                         </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">Tidak ada data investor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
