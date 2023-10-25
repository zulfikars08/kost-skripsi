@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Transaksi</h3>
    <!-- TRANSAKSI LIST TABLE -->
    <div class="d-flex justify-content-between align-items-center pb-3">
        <!-- SEARCH FORM -->
        <form class="d-flex" action="{{ route('transaksi.index') }}" method="get" id="search-form">
            <div class="input-group">
                {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                    aria-label="Search" id="search-input">
                <button class="btn btn-secondary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Include the modal partial -->

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generateReportModal">
            Excel
        </button>
        @include('transaksi.export')
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="white-space: nowrap;">No</th>
                <th style="white-space: nowrap;">No Kamar</th>
                <th style="white-space: nowrap;">Nama</th>
                <th style="white-space: nowrap;">Nama Kos</th>
                <th style="white-space: nowrap;">Tanggal</th>
                <th style="white-space: nowrap;">Jumlah Tarif</th>
                <th style="white-space: nowrap;">Tipe Pembayaran</th>
                <th style="white-space: nowrap;">Bukti Pembayaran</th>
                <th style="white-space: nowrap;">Status Pembayaran</th>
                <th style="white-space: nowrap;">Tanggal Awal</th>
                <th style="white-space: nowrap;">Tanggal Akhir</th>
                <th style="white-space: nowrap;">Kebersihan</th>
                <th style="white-space: nowrap;">Total</th>
                <th style="white-space: nowrap;">Keterangan</th>
                <th style="white-space: nowrap;">Pengeluaran</th>
                <th style="white-space: nowrap;">Action</th>
            </tr>
            <tr>
                
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksiData as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <!-- No Kamar -->
                <td>
                    @if ($item->kamar)
                        {{ $item->kamar->no_kamar }}
                    @endif
                </td>
                <!-- Nama -->
                <td>
                    @if ($item->penyewa)
                        {{ $item->penyewa->nama}}
                    @endif
                </td>
                <!-- Nama Kos -->
                <td>
                    @if ($item->lokasiKos)
                        {{ $item->lokasiKos->nama_kos }}
                    @endif
                </td>
                <!-- Tanggal -->
                <td>
                    {{ $item->tanggal ?? '-' }}
                </td>
                <!-- Jumlah Tarif -->
                <td>{{ $item->jumlah_tarif }}</td>
                <!-- Tipe Pembayaran -->
                <td>{{ $item->tipe_pembayaran ? $item->tipe_pembayaran : '-' }}</td>
                <td>
                    <!-- Display the proof of payment button/icon if it exists and payment type is "non-tunai" -->
                    @if ($item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran)
                        <button type="button" class="btn btn-link btn-sm"  style="background-color: blueviolet;color: aliceblue"   onclick="openImageModal('{{ asset('storage/' . $item->bukti_pembayaran) }}')">
                            <!-- Use an icon (e.g., an eye icon) to indicate viewing -->
                            <i class="fas fa-eye"></i>
                        </button>
                    @elseif ($item->tipe_pembayaran === 'tunai')
                        Cash Payment
                    @else
                        No Bukti Pembayaran
                    @endif
                </td>
                <td>
                    @if ($item->status_pembayaran === 'lunas')
                        <b><span style="color: green;">{{ $item->status_pembayaran }}</span></b>
                    @elseif ($item->status_pembayaran === 'cicil')
                        <b><span style="color: rgb(255, 123, 0);">{{ $item->status_pembayaran }}</span></b>
                    @elseif ($item->status_pembayaran === 'belum_lunas')
                        <b><span style="color: red;">{{ $item->status_pembayaran }}</span></b>
                    @else
                        {{ $item->status_pembayaran }}
                    @endif
                </td>
                <td>{{ $item->tanggal_pembayaran_awal ? $item->tanggal_pembayaran_awal : '-' }}</td>
                <td>{{ $item->tanggal_pembayaran_akhir ? $item->tanggal_pembayaran_akhir : '-' }}</td>

                <!-- Kebersihan -->
                <td>{{ $item->kebersihan }}</td>
                <!-- Total -->
                <td>{{ ($item->jumlah_tarif === 0 && $item->kebersihan === 0) ? 0 : ($item->jumlah_tarif - $item->kebersihan) }}</td>
                  <!-- Keterangan -->
                <td>{{ $item->keterangan }}</td>
                <!-- Pengeluaran -->
                <td>{{ $item->pengeluaran }}</td>
                <td>
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            Edit
                        </button>
                        @include('transaksi.edit')
                        <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline" action="{{ route('transaksi.destroy', $item->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit" class="btn btn-danger btn-sm" style="margin-left: 5px;">Delete</button>
                        </form>
                    </div>
                </td>
                             
            </tr>
            @empty
            <tr>
                <td colspan="16">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $transaksiData->withQueryString()->links() }}
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
</script>

@endsection
