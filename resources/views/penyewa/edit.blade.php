<div class="modal fade" id="editStatusPenyewaModal{{$penyewa->id}}" tabindex="-1" role="dialog" aria-labelledby="editStatusPenyewaModalLabel{{$penyewa->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStatusPenyewaModalLabel{{$penyewa->id}}">Ubah Status Penyewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penyewa.update', $penyewa->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Display the current status_penyewa value -->
                    <p>Current Status Penyewa: {{ $penyewa->status_penyewa }}</p>

                    <!-- Editable status_penyewa field -->
                    <div class="mb-3 custom-form-group">
                        <label for="status_penyewa">Edit Status Penyewa:</label>
                        <select class="form-control" name="status_penyewa" id="status_penyewa">
                            <option value="aktif" @if ($penyewa->status_penyewa === 'aktif') selected @endif>Aktif</option>
                            <option value="tidak_aktif" @if ($penyewa->status_penyewa === 'tidak_aktif') selected @endif>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
