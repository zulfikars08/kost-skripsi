@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Transaksi</h3>

    <!-- TRANSAKSI LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No Kamar</th>
                <th>Nama</th>
                <th>Nama Kos</th>
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
                <td>{{ $item->jumlah_tarif }}</td>
                <!-- Tipe Pembayaran -->
                <td>{{ $item->tipe_pembayaran_penyewa ? $item->tipe_pembayaran_penyewa : '-' }}</td>
                <td>{{ $item->bukti_pembayaran ? $item->bukti_pembayaran : '-' }}</td>
                <td>{{ $item->status_pembayaran_penyewa ? $item->status_pembayaran_penyewa : '-' }}</td>
                <td>{{ $item->tanggal_pembayaran_awal ? $item->tanggal_pembayaran_awal : '-' }}</td>
                <td>{{ $item->tanggal_pembayaran_akhir ? $item->tanggal_pembayaran_akhir : '-' }}</td>

                <!-- Kebersihan -->
                <td>{{ $item->kebersihan }}</td>
                <!-- Total -->
                <td>{{ ($item->jumlah_tarif === 0 && $item->kebersihan === 0) ? 0 : ($item->jumlah_tarif - $item->kebersihan) }}</td>
                <!-- Pengeluaran -->
                <td>{{ $item->pengeluaran }}</td>
                <!-- Keterangan -->
                <td>{{ $item->keterangan }}</td>
                <td>
                    <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                        action="{{ route('transaksi.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    {{-- <a href="{{ route('transaksi.show', $item->id) }}" class="btn btn-success btn-sm">Detail</a> --}}
                </td>
            </tr>
            
            @php
            $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
    {{ $transaksiData->withQueryString()->links() }}

</div>
@endsection
