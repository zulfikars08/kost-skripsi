@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0;">Laporan Keuangan</h3>
    <div class="mb-3 d-flex" style="text-end">
        <button class="btn btn-secondary mb-3 btn-block"
            onclick="window.location.href='{{ route('laporan-keuangan.index') }}'">Kembali</button>
        <div class="d-flex flex-column">
            <button type="button" class="btn btn-secondary btn-block" data-bs-toggle="modal"
                data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data Laporan
            </button>
            @include('laporan-keuangan.detail.create')
        </div>
        <div class="d-flex flex-column">
            <button type="button" class="btn btn-success mb-3 btn-block" data-bs-toggle="modal"
                data-bs-target="#generateReportModal">
                export to exel
            </button>
            @include('laporan-keuangan.export')
        </div>
    </div>


    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No Kamar</th>
                        <th>Nama Kos</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>Jumlah Pemasukan</th>
                        <th>Jumlah Pengeluaran</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanKeuangan as $item)
                    <tr>
                        <td>{{$loop->index + 1 }}
                        </td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->kamar->no_kamar }}</td>
                        <td>{{ $item->lokasi->nama_kos }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->jenis === 'pemasukan' ? $item->pemasukan : 0 }}</td>
                        <td>{{ $item->jenis === 'pengeluaran' ? $item->pengeluaran : 0 }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal{{ $item->id }}">
                                Edit
                            </button>
                            @include('laporan-keuangan.detail.edit')
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <!-- ... -->
                    <tr id="totalPemasukanRow">
                        <td colspan="6" class="text-end"><strong>Total Pemasukan:</strong></td>
                        <td><span id="totalPemasukan">0.00</span></td>
                        <td></td>
                    </tr>
                    <tr id="totalPengeluaranRow">
                        <td colspan="6" class="text-end"><strong>Total Pengeluaran:</strong></td>
                        <td></td>
                        <td><span id="totalPengeluaran">0.00</span></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end"><strong>Pendapatan Bersih:</strong></td>
                        <td></td>
                        <td><span id="pendapatanBersih">0.00</span></td>
                    </tr>

                </tfoot>
            </table>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    hitungTotal();

                    // Fungsi untuk menghitung total
                    function hitungTotal() {
    let totalPemasukan = 0;
    let totalPengeluaran = 0;
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const jenis = row.cells[4].textContent; // Kolom jenis (indeks 4)
        const pemasukan = parseFloat(row.cells[6].textContent); // Kolom pemasukan (indeks 6)
        const pengeluaran = parseFloat(row.cells[7].textContent); // Kolom pengeluaran (indeks 7)

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
    document.getElementById("totalPemasukan").textContent = totalPemasukan.toFixed(2);
    document.getElementById("totalPengeluaran").textContent = totalPengeluaran.toFixed(2);
    document.getElementById("pendapatanBersih").textContent = pendapatanBersih.toFixed(2);
}
                });
            </script>
        </div>
    </div>
</div>
@endsection