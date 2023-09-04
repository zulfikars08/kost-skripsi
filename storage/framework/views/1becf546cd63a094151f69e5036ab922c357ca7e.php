

<div class="modal fade" id="editModal<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo e($item->id); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel<?php echo e($item->id); ?>">Ubah Data Kamar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('kamar.update', $item->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <!-- Your form fields for editing go here -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_kamar" class="form-label text-start">No kamar</label>
                        <input type="text" class="form-control" id="no_kamar" value="<?php echo e($item->no_kamar); ?>" disabled>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="harga" class="form-label text-start">Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" value="<?php echo e($item->harga); ?>">
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label text-start">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo e($item->keterangan); ?>">
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="<?php echo e($item->fasilitas); ?>">
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label text-start">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="belum terisi" <?php if($item->status === 'belum terisi'): ?> selected <?php endif; ?>>Belum Terisi</option>
                            <option value="sudah terisi" <?php if($item->status === 'sudah terisi'): ?> selected <?php endif; ?>>Sudah Terisi</option>
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



<?php /**PATH C:\kost-skripsi\resources\views/kamar/edit.blade.php ENDPATH**/ ?>