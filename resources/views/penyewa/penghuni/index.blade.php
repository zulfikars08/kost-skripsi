@extends('layout.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <button type="button" style="display: flex; align-items: center; background-color: rgb(64, 174, 207); color: #fff; border: none; padding: 5px; border-radius: 5px;" onclick="window.location.href='{{ route('lokasi_kos.index') }}'">
                <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
            </button>
            <br>
            <div class="card">
                <div class="card-header bg-primary text-white text-start">
                    <h4 class="mb-0">Detail Penyewa</h4>
                </div>

                <div class="card-body p-4"> <!-- Added "p-4" class for padding -->
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-info text-white">Nama Penyewa</th>
                                <td>{{ $penyewa->nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">No Kamar</th>
                                <td>{{ $penyewa->no_kamar }}</td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">Status Penyewa</th>
                                <td>
                                    @if ($penyewa->status_penyewa === 'aktif')
                                    <button class="btn btn-success btn-sm">Aktif</button>
                                    @else
                                    <button class="btn btn-danger btn-sm">Tidak Aktif</button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">Nama Kos</th>
                                <td>
                                    @if ($penyewa->lokasi_id)
                                        <?php
                                        $lokasiKos = \App\Models\LokasiKos::find($penyewa->lokasi_id);
                                        ?>
                                        @if ($lokasiKos)
                                            {{ $lokasiKos->nama_kos }}
                                        @else
                                            No Lokasi Kos
                                        @endif
                                    @else
                                        No Kamar
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-info text-white">Jumlah Penghuni</th>
                                <td>{{ $jumlahPenghuni }}</td>
                            </tr>
                        </table>

                    <div class="d-flex justify-content-between align-items-left pb-3">
                        <h5 class="mt-4">Daftar Penghuni</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-left pb-3">
                        @if ($penyewa->status_penyewa === 'aktif')
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary" disabled>
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>
                            <div class="alert alert-danger mt-2 mx-auto text-center" role="alert">
                                Tidak dapat menambah data karena Status Penyewa tidak aktif.
                            </div>
                        @endif
                        @include('penyewa.penghuni.create')
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penghuni</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No Hp</th>
                                    <th>Pekerjaan</th>
                                    <th>Perusahaan</th>
                                    <th>Martial Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($penghuniList->isEmpty())
                                    <tr>
                                        <td colspan="9">Tidak ada data Penghuni</td>
                                    </tr>
                                @else
                                    @foreach ($penghuniList as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 + $penghuniList->perPage() * ($penghuniList->currentPage() - 1) }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->tanggal_lahir }}</td>
                                            <td>{{ $item->jenis_kelamin }}</td>
                                            <td>{{ $item->no_hp }}</td>
                                            <td>{{ $item->pekerjaan }}</td>
                                            <td>{{ $item->perusahaan }}</td>
                                            <td>{{ $item->martial_status }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editPenghuniModal{{ $item->id }}">
                                                    <i class="fas fa-edit" style="color: white"></i>
                                                </button>
                                                @include('penyewa.penghuni.edit')
                                                <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                                                    action="{{ route('penyewa.penghuni.destroy', ['id' => $item->id]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" name="submit" class="btn btn-danger btn-sm" onclick="showSuccessToast()">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
