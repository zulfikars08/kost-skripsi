@extends('layout.template')

@section('content')
<div class="container-fluid">
    <div class="mb-3 text-start">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Kembali</a>
    </div>    
    <h3 class="text-start" style="margin: 20px 0;">Detail Transaksi</h3>
    <!-- Add these buttons to your Blade view -->
<div class="mb-3 text-end">
    <a href="{{ route('transaksi.export.excel') }}" class="btn btn-success">Export to Excel</a>
</div>
@foreach($groupedTransaksi as $namaKos => $transaksiData)
    <!-- Tampilkan data transaksi yang sesuai dengan bulan dan tahun -->
    <table class="table table-striped">
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
                <th>Status Pembayaran</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
                <th>Kebersihan</th>
                <th>Total</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 1;
            @endphp
            @foreach ($transaksiData as $item)
            <tr>
                <td>{{ $i }}</td>
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
                <!-- Jumlah Tarif -->
                <td>
                    {{ $item->tanggal ?? '-' }}
                </td>
                <td>{{ $item->jumlah_tarif }}</td>
                <!-- Tipe Pembayaran -->
                <td>{{ $item->tipe_pembayaran ? $item->tipe_pembayaran : '-' }}</td>
                <!-- Bukti Pembayaran -->
                <td>
                    @if ($item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran)
                        <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank">Lihat Bukti Pembayaran</a>
                    @elseif ($item->tipe_pembayaran === 'tunai')
                        Cash Payment
                    @else
                        No Bukti Pembayaran
                    @endif
                </td>
                <!-- Status Pembayaran -->
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
                <!-- Tanggal Awal -->
                <td>{{ $item->tanggal_pembayaran_awal ? $item->tanggal_pembayaran_awal : '-' }}</td>
                <!-- Tanggal Akhir -->
                <td>{{ $item->tanggal_pembayaran_akhir ? $item->tanggal_pembayaran_akhir : '-' }}</td>
                <!-- Kebersihan -->
                <td>{{ $item->kebersihan }}</td>
                <!-- Total -->
                <td>{{ ($item->jumlah_tarif === 0 && $item->kebersihan === 0) ? 0 : ($item->jumlah_tarif - $item->kebersihan) }}</td>
                <!-- Pengeluaran -->
                <td>{{ $item->pengeluaran }}</td>
                <!-- Keterangan -->
                <td>{{ $item->keterangan }}</td>
                <!-- Action -->
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                        Edit
                    </button>
                    @include('transaksi.edit')
                    <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline" action="{{ route('transaksi.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @php
            $i++;
            @endphp
            @endforeach
        </tbody>
    </table>  
    @endforeach  

@endsection
