<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tipe Kamar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i = 1; // Start numbering from 1
            @endphp
            @forelse ($tipeKamar as $item)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $item->tipe_kamar }}</td>
                <td>
                    <button class="btn btn-sm" style="background-color: #ffbe45" data-bs-toggle="modal"
                        data-bs-target="#editDataModal{{ $item->id }}" title="Edit">
                        <i class="fas fa-edit" style="color: white"></i>
                    </button>
                    @include('tipe_kamar.edit') <!-- Include the modal partial for editing data -->

                    <button class="btn btn-sm" style="background-color: #eb6a6a;" data-bs-toggle="modal"
                        data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                        <i class="fas fa-trash" style="color: white"></i>
                    </button>
                    @include('tipe_kamar.delete') <!-- Include the modal partial for deleting data -->
                </td>
            </tr>
            @php
            $i++;
            @endphp
            @empty
            <tr>
                <td colspan="3">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{-- {{ $fasilitas->links() }} <!-- Display pagination links --> --}}
</div>