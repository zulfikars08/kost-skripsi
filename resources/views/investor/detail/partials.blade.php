<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
    <table class="table table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th style="white-space: nowrap;">No</th>
                <th style="white-space: nowrap;">Nama</th>
                <th style="white-space: nowrap;">Bulan</th>
                <th style="white-space: nowrap;">Tahun</th>
                <th style="white-space: nowrap;">Jumlah Pintu</th>
                <th style="white-space: nowrap;">Lokasi</th>
                <th style="white-space: nowrap;">Total Kamar</th>
                <th style="white-space: nowrap;">Pendapatan Bersih</th>
                <th style="white-space: nowrap;">Total Pendapatan</th>
                <th style="white-space: nowrap;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($investors as $investor)
            <tr>
                <td>{{ $loop->index + 1 + $investors->perPage() * ($investors->currentPage() - 1) }}</td>
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
                    {{ $lastPendapatanBersih }}
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

                    {{ $totalPendapatan }}
                    <!-- Display the total pendapatan -->
                </td>

                <td>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editModal{{ $investor->id }}">
                        <i class="fas fa-edit" style="color: white"></i> <!-- Edit Icon -->
                    </button>
                    @include('investor.detail.edit')
                    <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                        data-bs-target="#deleteModal{{ $investor->id }}" style="margin-left: 10px">
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
        </tbody>
    </table>
</div>