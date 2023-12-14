<!-- resources/views/pengeluaran/index.blade.php -->

@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Pengeluaran</h3>

    
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- Tambah Data Button -->
            <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-secondary" type="submit">Reset Filter</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal" style="margin-left: 10px">
                Filter
            </button>
            @include('pengeluaran.filter')
            </div>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataPengeluaranModal" style="margin-left: 10px">
            <i class="fas fa-plus"></i> Tambah Data
         </button>
             @include('pengeluaran.create')
            <!-- Include the modal partial -->  
        </div>
        <div class="table-responsive" >
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="white-space: nowrap;">Kode Pengeluaran</th>
                    <th style="white-space: nowrap;">No Kamar</th>
                    <th style="white-space: nowrap;">Lokasi Kos</th>
                    <th style="white-space: nowrap;">Tanggal</th>
                    <th style="white-space: nowrap;">Tipe Pembayaran</th>
                    <th style="white-space: nowrap;">Bukti Pembayaran</th>
                    <th style="white-space: nowrap;">Jumlah</th>
                    <th style="white-space: nowrap;">Tanggal Pembayaran Awal</th>
                    <th style="white-space: nowrap;">Tanggal Pembayaran Akhir</th>
                    <th style="white-space: nowrap;">Status Pembayaran</th>
                    <th style="white-space: nowrap;">Keterangan</th>
                    <th style="white-space: nowrap;">Aksi</th>
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluaran as $item)
                    <tr>
                        <td>{{ $item->kode_pengeluaran }}</td>
                        <td>{{ $item->kamar->no_kamar }}</td>
                        <td>{{ $item->lokasiKos->nama_kos }}</td>
                        <td style="white-space: nowrap;">{{ $item->tanggal }}</td>
                        <td>{{ $item->tipe_pembayaran ? $item->tipe_pembayaran : '-' }}</td>
                        <td>
                            <!-- Display the proof of payment button/icon if it exists and payment type is "non-tunai" -->
                            @if ($item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran)
                            <button type="button" class="btn btn-link btn-sm" onclick="openImageModal('{{ asset('storage/' . $item->bukti_pembayaran) }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            @elseif ($item->tipe_pembayaran === 'tunai')
                                Cash Payment
                            @else
                                No Bukti Pembayaran
                            @endif
                        </td>
                        <td style="white-space: nowrap;">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->tanggal_pembayaran_awal ? $item->tanggal_pembayaran_awal : '-' }}</td>
                        <td>{{ $item->tanggal_pembayaran_akhir ? $item->tanggal_pembayaran_akhir : '-' }}</td>
                        <td>
                            @if ($item->status_pembayaran === 'lunas')
                            <b><span style="color: green;"> Lunas </span></b>
                            @elseif ($item->status_pembayaran === 'cicil')
                            <b><span style="color: rgb(255, 123, 0);"> Cicil </span></b>
                            @elseif ($item->status_pembayaran === 'belum_lunas')
                            <b><span style="color: red;"> Belum Lunas </span></b>
                            @else
                            {{ $item->status_pembayaran }}
                            @endif
                        </td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" style="margin-left: 10px">
                                <i class="fas fa-trash" style="color: white"></i>
                            </button>
                            @include('pengeluaran.delete') 
                        </td>
                        {{-- <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editPengeluaranModal{{ $item->id }}">
                                Edit
                            </button>
                        </td> --}}
                    </tr>
                    {{-- @include('pengeluaran.edit_modal', ['pengeluaran' => $item]) --}}
                @endforeach
            </tbody>
        </table>
        {{ $pengeluaran->links() }}
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="buktiPembayaranImage" src="" alt="Bukti Pembayaran" class="img-fluid" style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageUrl) {
            // Set the image source
            document.getElementById('buktiPembayaranImage').src = imageUrl;
            // Open the modal
            $('#imageModal').modal('show');
        }

        function openEditModal(itemId) {
    // Open the modal using the updated ID
    $(`#editModal${itemId}`).modal('show');
}

    </script>
</div>


@endsection
