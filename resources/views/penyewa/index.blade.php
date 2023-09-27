@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Penyewa</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('penyewa.index') }}" method="get" id="search-form">
                <div class="input-group">
                    {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                    <input class="form-control" type="search" name="search" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>
            

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('penyewa.create')
            <!-- Include the modal partial -->
        </div>
    </div>
    

    <!-- PENYEWA LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nama Kos</th>
                <th>No. Kamar</th>
                {{-- <th>Tipe Pembayaran</th>
                <th>Jumlah Tarif</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th> --}}
                <th>Status Penyewa</th>
                {{-- <th>Status Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Keterangan</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penyewas as $penyewa)
            <tr>
                <td>{{ $loop->index + 1 + $penyewas->perPage() * ($penyewas->currentPage() - 1) }}</td>
                <td>{{ $penyewa->nama }}</td>
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
                <td>{{ $penyewa->no_kamar }}</td>
                {{-- <td>{{ $penyewa->tipe_pembayaran }}</td>
                <td>{{ $penyewa->jumlah_tarif }}</td>
                <td>{{ $penyewa->tanggal_pembayaran_awal ? $penyewa->tanggal_pembayaran_awal : '-' }}</td>
                <td>{{ $penyewa->tanggal_pembayaran_akhir ? $penyewa->tanggal_pembayaran_akhir : '-' }}</td> --}}
                {{-- <td>
                    @if ($penyewa->status_pembayaran === 'lunas')
                        <b><span style="color: green;">{{ $penyewa->status_pembayaran }}</span></b>
                    @elseif ($penyewa->status_pembayaran === 'cicil')
                        <b><span style="color: rgb(255, 123, 0);">{{ $penyewa->status_pembayaran }}</span></b> --}}
                    {{-- @elseif ($penyewa->status_pembayaran === 'belum_lunas')
                        <b><span style="color: red;">{{ $penyewa->status_pembayaran }}</span></b> --}}
                    {{-- @else
                        {{ $penyewa->status_pembayaran }}
                    @endif
                </td>
                <td> --}}
                    <!-- Display the proof of payment button/icon if it exists and payment type is "non-tunai" -->
                    {{-- @if ($penyewa->tipe_pembayaran === 'non-tunai' && $penyewa->bukti_pembayaran)
                        <button type="button" class="btn btn-link btn-sm"  style="background-color: blueviolet;color: aliceblue"   onclick="openImageModal('{{ asset('storage/' . $penyewa->bukti_pembayaran) }}')">
                            <!-- Use an icon (e.g., an eye icon) to indicate viewing -->
                            <i class="fas fa-eye"></i>
                        </button>
                    @elseif ($penyewa->tipe_pembayaran === 'tunai')
                        Cash Payment
                    @else
                        No Bukti Pembayaran
                    @endif
                </td> --}}
                <td>
                    @if ($penyewa->status_penyewa === 'aktif')
                        <button class="btn btn-success btn-sm">Aktif</button>
                    @else
                        <button class="btn btn-danger btn-sm">Tidak Aktif</button>
                    @endif
                </td>
                {{-- <td>{{ $penyewa->keterangan }}</td> --}}
                <td>
                    {{-- <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                        action="{{ route('penyewa.destroy', $penyewa->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form> --}}
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStatusPenyewaModal{{ $penyewa->id }}">
                        <i class="fas fa-edit" style="color: white"></i> <!-- Edit Icon -->
                    </button>
                    @include('penyewa.edit')
                    <a href="{{ route('penyewa.show', $penyewa->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle" style="color: white"></i> <!-- Detail Icon -->
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $penyewas->withQueryString()->links() }}
</div>

<!-- Modal Dialog -->
<!-- Modal for displaying the image -->
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



<!-- Your modal HTML here -->

<script>
    function openImageModal(imageUrl) {
    // Set the image source
    document.getElementById('buktiPembayaranImage').src = imageUrl;
    // Open the modal
    $('#imageModal').modal('show');
}

</script>




@endsection
