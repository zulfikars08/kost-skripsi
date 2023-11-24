@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <button type="button"
        style="display: flex; align-items: center; background-color: rgb(64, 174, 207); color: #fff; border: none; padding: 5px; border-radius: 5px;"
        onclick="window.location.href='{{ route('investor.index') }}'">
        <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
    </button>
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Investor
    </h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('investor.detail.index') }}" method="get" id="search-form">
                <div class="input-group">
                    <input class="form-control" type="search" name="nama" placeholder="Masukkan nama"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>



            <div class="d-flex justify-content-between mb-3">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#tambahDataModal">
                    <i class="fas fa-plus"></i> Tambah Data Investor
                </button>
                @include('investor.detail.create')
                <button type="button" class="btn btn-success" style="margin-left: 3px" data-bs-toggle="modal"
                    data-bs-target="#generateReportModals">
                    Excel
                </button>
                @include('investor.export')
            </div>
            <!-- Include the modal partial -->
        </div>

        <!-- INVESTOR LIST TABLE -->
        <!-- INVESTOR LIST TABLE -->
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">No</th>
                        <th style="white-space: nowrap;">Nama</th>
                        <th style="white-space: nowrap;">Bulan</th>
                        <th style="white-space: nowrap;">Tahun</th>
                        <th style="white-space: nowrap;">Jumlah Pintu</th>
                        <th style="white-space: nowrap;">Lokasi</th>
                        <th style="white-space: nowrap;">Total Kamar</th>
                        <th style="white-space: nowrap;">Pendapatan Bersih</th>
                        <th style="white-space: nowrap;">Total Pendapatan</th>
                        <th style="white-space: nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($investors as $investor)
                    <tr>
                        <td>{{ $loop->index + 1 + $investors->perPage() * ($investors->currentPage() - 1) }}</td>
                        <td>{{ $investor->nama }}</td>
                        <td>{{ $months[$investor->bulan] }}</td>
                        <td>{{$investor->tahun}}</td>
                        <td>{{ $investor->jumlah_pintu }}</td>
                        <td>
                            {{ $investor->lokasiKos->nama_kos }}
                        </td>
                        <td>
                            @if ($investor->lokasi_id)
                            <?php
                        $lokasiKos = \App\Models\LokasiKos::find($investor->lokasi_id);
                    ?>
                            @if ($lokasiKos)
                            {{ $lokasiKos->jumlah_kamar }}
                            <!-- Display the total kamar -->
                            @else
                            No Lokasi Kos
                            @endif
                            @else
                            No Lokasi
                            @endif
                        </td>
                        <td>
                            @php
                            $lastPendapatanBersih = \App\Models\LaporanKeuangan::where('nama_kos', $investor->nama_kos)
                            ->where('bulan', $investor->bulan)
                            ->where('tahun', $investor->tahun)
                            ->orderBy('id', 'desc')
                            ->value('pendapatan_bersih');
                            @endphp
                            {{ $lastPendapatanBersih }}
                        </td>

                        <td>
                            @php
                            $laporanKeuangan = \App\Models\LaporanKeuangan::where('nama_kos', $investor->nama_kos)
                            ->where('bulan', $investor->bulan)
                            ->where('tahun', $investor->tahun)
                            ->orderBy('id', 'desc')
                            ->first();

                            $totalPendapatan = ($laporanKeuangan) ? ($investor->jumlah_pintu / max(1,
                            $lokasiKos->jumlah_kamar)) * $laporanKeuangan->pendapatan_bersih : 0;
                            @endphp

                            {{ $totalPendapatan }}
                            <!-- Display the total pendapatan -->
                        </td>

                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $investor->id }}">
                                <i class="fas fa-edit" style="color: white"></i> <!-- Edit Icon -->
                            </button>
                            @include('investor.detail.edit')
                            <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $investor->id }}" style="margin-left: 10px">
                                <i class="fas fa-trash" style="color: white"></i>
                            </button>
                            @include('investor.detail.delete')
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">Tidak ada data investor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection