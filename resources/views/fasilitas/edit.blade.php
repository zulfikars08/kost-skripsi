<!-- Edit Modal -->
<div class="modal fade" id="editDataModal{{ $item->id }}" tabindex="-1" aria-labelledby="editDataModalLabel{{ $item->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel{{ $item->id }}">Edit Data Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('fasilitas.update', $item->id) }}" method="post">
                @csrf
                @method('PUT') <!-- Use the PUT method for updates -->

                <div class="modal-body">
                    <!-- Your form fields for editing -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama_fasilitas" class="form-label">Nama Fasilitas</label>
                        <input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" value="{{ $item->nama_fasilitas }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
