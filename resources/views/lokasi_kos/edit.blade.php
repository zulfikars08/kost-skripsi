<!-- Edit Modal -->
<div class="modal fade" id="editDataModal{{ $item->id }}" tabindex="-1"
    aria-labelledby="editDataModal{{ $item->id }}Label" aria-hidden="true">
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $item->id }}Label">Edit Data Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Your edit form goes here -->
                <form action="{{ route('lokasi_kos.update', $item->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                        <div class="mb-3 custom-form-group">
                            <label for="nama_kos" class="form-label">Lokasi Kos</label>
                            <input type="text" class="form-control" name="nama_kos" id="nama_kos" value="{{ $item->nama_kos }}">
                        </div>
                        <div class="mb-3 custom-form-group">
                            <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                            <input type="text" class="form-control" name="jumlah_kamar" id="jumlah_kamar" value="{{ $item->jumlah_kamar }}">
                        </div>
                        <div class="mb-3 custom-form-group">
                            <label for="alamat_kos" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat_kos" id="alamat_kos" value="{{ $item->alamat_kos }}">
                        </div>
                        <!-- Button to submit the form -->
                            <div class="mb-3 custom-form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>


