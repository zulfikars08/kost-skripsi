@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <button type="button"
        style="display: flex; align-items: center; background-color: rgb(64, 174, 207); color: #fff; border: none; padding: 5px; border-radius: 5px;"
        onclick="window.location.href='{{ route('laporan-keuangan.index') }}'">
        <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
    </button>
    <h3 class="text-start" style="margin: 20px 0;">Laporan Keuangan</h3>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            {{-- <div class="d-flex flex-column">
                <button type="button"
                    style="display: flex; align-items: center; background-color: rgb(64, 174, 207); color: #fff; border: none; padding: 5px; border-radius: 5px;"
                    data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                    <i class="fas fa-plus"></i> Tambah Data Laporan
                </button>
                @include('laporan-keuangan.detail.create')
            </div> --}}
            <!-- Include the filter modal -->
            {{-- <form class="d-flex" id="search-form">
                <div class="input-group">
                    <input class="form-control me-2" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form> --}}
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-secondary" type="submit" style="margin-left: 5px">Reset Filter</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal"
                    style="margin-left: 5px">
                    Filter
                </button>
                @include('laporan-keuangan.detail.filter')
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" style="margin-left:5px"
                data-bs-target="#generateReportModal">
                Excel
            </button>
            @include('laporan-keuangan.export')
        </div>

        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="white-space: nowrap;">Kode Laporan</th>
                        <th style="white-space: nowrap;">Kode Pemasukan</th>
                        <th style="white-space: nowrap;">Kode Pengeluaran</th>
                        <th style="white-space: nowrap;">Tanggal</th>
                        <th style="white-space: nowrap;">No Kamar</th>
                        <th style="white-space: nowrap;">Nama Kos</th>
                        <th style="white-space: nowrap;">Tipe Pembayaran</th>
                        <th style="white-space: nowrap;">Jenis</th>
                        <th style="white-space: nowrap;">Bukti Pembayaran</th>
                        <th style="white-space: nowrap;">Tanggal Pembayaran Awal</th>
                        <th style="white-space: nowrap;">Tanggal Pembayaran Akhir</th>
                        <th style="white-space: nowrap;">Status Pembayaran</th>
                        <th style="white-space: nowrap;">Jumlah Pemasukan</th>
                        <th style="white-space: nowrap;">Jumlah Pengeluaran</th>
                        <th style="white-space: nowrap;">Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanKeuangan as $item)
                    <tr>
                        <td>{{$loop->index + 1 }}</td>
                        <td>{{$item->kode_laporan}}</td>
                        <td>{{$item->kode_pemasukan}}</td>
                        <td>{{$item->kode_pengeluaran}}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->kamar->no_kamar }}</td>
                        <td>{{ $item->lokasiKos->nama_kos }}</td>
                        <td>{{ $item->tipe_pembayaran ? $item->tipe_pembayaran : '-' }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>
                            <!-- Display the proof of payment button/icon if it exists and payment type is "non-tunai" -->
                            @if ($item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran)
                            <button type="button" class="btn btn-link btn-sm"
                                onclick="openImageModal('{{ asset('storage/' . $item->bukti_pembayaran) }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            @elseif ($item->tipe_pembayaran === 'tunai')
                            Cash Payment
                            @else
                            No Bukti Pembayaran
                            @endif
                        </td>
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
                        <td>Rp {{ number_format( $item->jenis === 'pemasukan' ? $item->pemasukan : 0) }}</td>
                        <td>Rp {{ number_format($item->jenis === 'pengeluaran' ? $item->pengeluaran : 0) }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>
                            <div class="d-flex justify-content-center">

                                <button class="btn btn-sm" style="background-color: #ffbe45" data-bs-toggle="modal"
                                    data-bs-target="#editDataModal{{ $item->id }}">
                                    <i class="fas fa-edit" style="color: white"></i>
                                </button>
                                @include('laporan-keuangan.detail.edit')


                                <button class="btn btn-sm" style="background-color: #eb6a6a;margin-left: 10px"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="fas fa-trash" style="color: white"></i>
                                </button>
                                @include('laporan-keuangan.detail.delete')

                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <!-- ... -->
                    <tr id="totalPemasukanRow">
                        <td colspan="13" class="text-end"><strong style="text">Total Pemasukan:</strong></td>
                        <td><span id="totalPemasukan">0.00</span></td>
                        <td></td>
                    </tr>
                    <tr id="totalPengeluaranRow">
                        <td colspan="13" class="text-end"><strong>Total Pengeluaran:</strong></td>
                        <td></td>
                        <td><span id="totalPengeluaran">0.00</span></td>
                    </tr>
                    <tr>
                        <td colspan="13" class="text-end"><strong>Pendapatan Bersih:</strong></td>
                        <td></td>
                        <td><span id="pendapatanBersih">0.00</span></td>
                    </tr>

                </tfoot>
            </table>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Call the function to calculate totals when the page is loaded
                    calculateTotals();
            
                    // Function to calculate totals
                    function calculateTotals() {
                        let totalPemasukan = 0;
                        let totalPengeluaran = 0;
                        const rows = document.querySelectorAll("tbody tr");
            
                        rows.forEach(row => {
                            const pemasukan = parseFloat(row.cells[13].textContent.replace('Rp', '').replace(',', '')); // Kolom pemasukan (indeks 13)
                            const pengeluaran = parseFloat(row.cells[14].textContent.replace('Rp', '').replace(',', '')); // Kolom pengeluaran (indeks 14)
            
                            if (!isNaN(pemasukan)) {
                                totalPemasukan += pemasukan;
                            }
            
                            if (!isNaN(pengeluaran)) {
                                totalPengeluaran += pengeluaran;
                            }
                        });
            
                        // Hitung total pendapatan bersih
                        const pendapatanBersih = totalPemasukan - totalPengeluaran;
            
                        // Perbarui total pemasukan, pengeluaran, dan pendapatan bersih
                        document.getElementById("totalPemasukan").textContent = `Rp ${totalPemasukan.toFixed(2)}`;
                        document.getElementById("totalPengeluaran").textContent = `Rp ${totalPengeluaran.toFixed(2)}`;
                        document.getElementById("pendapatanBersih").textContent = `Rp ${pendapatanBersih.toFixed(2)}`;
                    }
                });
            </script>
        </div>
    </div>
</div>
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="buktiPembayaranImage" src="" alt="Bukti Pembayaran" class="img-fluid"
                    style="max-width: 100%; max-height: 80vh;">
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