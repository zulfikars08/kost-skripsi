@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Investor
    </h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('investor.detail.index') }}" method="get" id="search-form">
                <div class="input-group">
                    <input class="form-control" type="search" name="nama" placeholder="Masukkan nama" aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>
            

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data Investor
            </button>
            @include('investor.detail.create')
            <!-- Include the modal partial -->
        </div>

<!-- INVESTOR LIST TABLE -->
<!-- INVESTOR LIST TABLE -->
<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
    <table class="table table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Pintu</th>
                <th>Lokasi</th>
                <th>Total Kamar</th>
                <th>Pendapatan Bersih</th>
                <th>Total Pendapatan</th>
                <th>Action</th>
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
                    {{ $lokasiKos->jumlah_kamar }} <!-- Display the total kamar -->
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
                    
                    $totalPendapatan = ($laporanKeuangan) ? ($investor->jumlah_pintu / max(1, $lokasiKos->jumlah_kamar)) * $laporanKeuangan->pendapatan_bersih : 0;
                    @endphp
                
                    {{ $totalPendapatan }} <!-- Display the total pendapatan -->
                </td>
                
                <td>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editModal{{$investor->id}}">
                        <i class="fas fa-edit" style="color: white"></i> <!-- Edit Icon -->
                    </button>
                    {{-- @include('kamar.edit', ['item' => $item]) --}}
                    {{-- <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                        action="{{ route('kamar.destroy', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm"
                            onclick="showSuccessToast()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form> --}}
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