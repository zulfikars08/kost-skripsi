<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus baris ini?
            </div>
            <div class="modal-footer">
                <form 
                action="{{ route('tanggal-laporan.destroy', $item->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" name="submit" class="btn btn-danger btn-sm"
                    onclick="showSuccessToast()">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
