<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi Kos</th>
                <th>
                    <!-- Sort by Jumlah Kamar dropdown here -->
                    <div class="dropdown">
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="jumlahKamarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Jumlah Kamar
                        </a>
                        <div class="dropdown-menu" aria-labelledby="jumlahKamarDropdown">
                            <form action="{{ route('lokasi_kos.index') }}" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="sort_by" id="sort_by" required>
                                        <option value="">Sort by</option>
                                        <option value="jumlah_kamar_asc">Jumlah Kamar - Terkecil ke Terbesar</option>
                                        <option value="jumlah_kamar_desc">Jumlah Kamar - Terbesar ke Terkecil</option>
                                    </select>
                                </div>
                                <br>
                                <div class="modal-footer px-2">
                                    <button type="submit" class="btn btn-primary">Sort</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </th>
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
                    <button class="btn btn-sm btn-hover" style="background-color: #ffbe45" data-bs-toggle="modal"
                            data-bs-target="#editDataModal{{ $item->id }}" title="Edit">
                        <i class="fas fa-edit" style="color: white"></i>
                    </button>
                    @include('lokasi_kos.edit')
                
                    <button class="btn btn-sm btn-hover" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                        <i class="fas fa-trash" style="color: white"></i>
                    </button>
                    @include('lokasi_kos.delete')
                
                    <a href="{{ route('lokasi_kos.detail', $item->id) }}" class="btn btn-primary btn-sm btn-hover" title="Detail">
                        <i class="fas fa-info-circle" style="color: white"></i>
                    </a>
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
    {{ $data->links() }}
</div>
