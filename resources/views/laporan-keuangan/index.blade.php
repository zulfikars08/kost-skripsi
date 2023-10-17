<!-- resources/views/financial-report.blade.php -->

@extends('layout.template')

@section('content')
<div class="container">
    <h3>Financial Report</h3>
    <p>Generated for: {{ $namaKos }} - {{ $namaBulan }}</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Kamar</th>
                <th>Nama</th>
                <th>Nama Kos</th>
                <th>Tanggal</th>
                <th>Jumlah Tarif</th>
                <th>Tipe Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Tanggal Awal Pembayaran</th>
                <th>Tanggal Akhir Pembayaran</th>
                <th>Kebersihan</th>
                <th>Total</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filteredTransaksiData as $item)
            <tr>
                <td>{{ $item['No'] }}</td>
                <td>{{ $item['No Kamar'] }}</td>
                <td>{{ $item['Nama'] }}</td>
                <td>{{ $item['Nama Kos'] }}</td>
                <td>{{ $item['Tanggal'] }}</td>
                <td>{{ $item['Jumlah Tarif'] }}</td>
                <td>{{ $item['Tipe Pembayaran'] }}</td>
                <td>{{ $item['Bukti Pembayaran'] }}</td>
                <td>{{ $item['Tanggal Awal Pembayaran'] }}</td>
                <td>{{ $item['Tanggal Akhir Pembayaran'] }}</td>
                <td>{{ $item['Kebersihan'] }}</td>
                <td>{{ $item['Total'] }}</td>
                <td>{{ $item['Pengeluaran'] }}</td>
                <td>{{ $item['Keterangan'] }}</td>
                <td>{{ $item['Status Pembayaran'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
