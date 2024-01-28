@forelse ($investors as $investor)
<tr>
    <td>{{ $loop->index + 1}}</td>
    <td>{{ $investor->nama }}</td>
    <td>{{ $months[$investor->bulan] }}</td>
    <td>{{$investor->tahun}}</td>
    <td>{{ $investor->jumlah_pintu }}</td>
    <td>
        {{ $investor->lokasiKos->nama_kos }}
    </td>
    <td>
        @if ($investor->lokasi_id)
            @php
                $lokasiKos = App\Models\LokasiKos::find($investor->lokasi_id);
            @endphp
            {{ $lokasiKos ? $lokasiKos->jumlah_kamar : 'No Lokasi Kos' }}
        @else
            No Lokasi
        @endif
    </td>
    <td>
        @php
        $lastPendapatanBersih = \App\Models\LaporanKeuangan::where('nama_kos', $investor->nama_kos)
        ->where('bulan', $investor->bulan)
        ->where('tahun', $investor->tahun)
        ->orderBy('id', 'desc')
        ->value('pendapatan_bersih');
        @endphp
        Rp {{ number_format($lastPendapatanBersih, 0, ',', '.') }}
    </td>

    <td>
        @php
        $laporanKeuangan = \App\Models\LaporanKeuangan::where('nama_kos', $investor->nama_kos)
        ->where('bulan', $investor->bulan)
        ->where('tahun', $investor->tahun)
        ->orderBy('id', 'desc')
        ->first();

        $totalPendapatan = ($laporanKeuangan) ? ($investor->jumlah_pintu / max(1,
        $lokasiKos->jumlah_kamar)) * $laporanKeuangan->pendapatan_bersih : 0;
        @endphp

        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        
    </td>

    <td>
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
            data-bs-target="#editModal{{ $investor->id }}">
            <i class="fas fa-edit" style="color: white" title="Edit"></i> <!-- Edit Icon -->
        </button>
        @include('investor.detail.edit')
        <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
            data-bs-target="#deleteModal{{ $investor->id }}" style="margin-left: 10px" title="Delete">
            <i class="fas fa-trash" style="color: white"></i>
        </button>
        @include('investor.detail.delete')
    </td>
</tr>
@empty
<tr>
    <td colspan="10">Tidak ada data investor.</td>
</tr>
@endforelse