<div class="table-responsive">
    <table class="table table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th> <!-- Add the ID column -->
                <th>Nama</th>
                <th>No Kamar</th>
                <th>Lokasi Kos</th>
                <th>Status Penyewa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penyewas as $penyewa)
            <tr>
                <td>{{ $loop->index + 1 + $penyewas->perPage() * ($penyewas->currentPage() - 1) }}</td>
                <td>{{ $penyewa->kode_penyewa }}</td> <!-- Display the ID -->
                <td>{{ $penyewa->nama }}</td>
                <td>{{ $penyewa->kamar->no_kamar }}</td>
                <td>{{ $penyewa->lokasiKos->nama_kos }}</td>
                <td>
                    @if ($penyewa->status_penyewa === 'aktif')
                    <button class="btn btn-success btn-sm">Aktif</button>
                    @else
                    <button class="btn btn-danger btn-sm">Tidak Aktif</button>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editStatusPenyewaModal{{ $penyewa->id }}" title="Edit">
                        <i class="fas fa-edit" style="color: white"></i>
                    </button>
                    @include('penyewa.edit')
                    <a href="{{ route('penyewa.show', $penyewa->id) }}" class="btn btn-primary btn-sm" title="Detail">
                        <i class="fas fa-info-circle" style="color: white"></i>
                    </a>
                    {{-- <button class="btn btn-sm" style="background-color: #eb6a6a;"
                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $penyewa->id }}" title="Delete" {{ $penyewa->status_penyewa === 'tidak_aktif' ? 'disabled' : '' }}>
                    <i class="fas fa-trash" style="color: white"></i>
                </button>
                @include('penyewa.delete') --}}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $penyewas->withQueryString()->links() }}
</div>