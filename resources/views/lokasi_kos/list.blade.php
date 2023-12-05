<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi Kos</th>
                <th>Jumlah Kamar</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = $data->firstItem();
            @endphp
            @forelse ($data as $item)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $item->nama_kos }}</td>
                <td>{{ $item->jumlah_kamar }}</td>
                <td>{{ $item->alamat_kos }}</td>
                <td>
                    <button class="btn btn-sm" style="background-color: #eb6a6a;margin-left: 10px" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $item->id }}">
                                <i class="fas fa-trash" style="color: white"></i>
                            </button>
                    @include('lokasi_kos.delete')
                    <a href="{{ route('lokasi_kos.detail', $item->id) }}" class="btn btn-primary btn-sm"> 
                        <i class="fas fa-info-circle" style="color: white"></i></a>
                </td>
            </tr>
            @php
            $i++;
            @endphp
            @empty
            <tr>
                <td colspan="5">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $data->withQueryString()->links() }}
</div>