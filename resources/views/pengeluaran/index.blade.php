<!-- resources/views/pengeluaran/index.blade.php -->

@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Pengeluaran</h3>

    
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('lokasi_kos.index') }}" method="get" id="search-form">
                <div class="input-group">
                    {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataPengeluaranModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('pengeluaran.create')
            <!-- Include the modal partial -->
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Pengeluaran</th>
                    <th>No Kamar</th>
                    <th>Nama Kos</th>
                    <th>Tanggal</th>
                    <th>Tipe Pembayaran</th>
                    <th>Bukti Pembayaran</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($expenditures as $item)
                    <tr>
                        <td>{{ $item->kode_pengeluaran }}</td>
                        <td>{{ $item->kamar->no_kamar }}</td>
                        <td>{{ $item->lokasiKos->nama_kos }}</td>
                        <td>{{ $item->tanggal }}</td>
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
                        <td>{{ $item->jumlah }}</td>
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
