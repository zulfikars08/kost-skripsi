<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('kamar.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Your form for adding data goes here -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_kamar" class="form-label">No Kamar</label>
                        <input type="text" class="form-control" name="no_kamar" id="no_kamar" value="<?php echo e(old('no_kamar')); ?>" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" value="<?php echo e(old('harga')); ?>" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="<?php echo e(old('fasilitas')); ?>" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="belum terisi" <?php if(old('status') === 'belum terisi'): ?> selected <?php endif; ?>>Belum Terisi</option>
                            <option value="sudah terisi" <?php if(old('status') === 'sudah terisi'): ?> selected <?php endif; ?>>Sudah Terisi</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo e(old('keterangan')); ?>" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="kost_id" class="form-label">Lokasi Kos</label>
                        <select class="form-control" name="kost_id" id="kost_id" required>
                            <option value="">Pilih Lokasi Kos</option>
                            <?php $__currentLoopData = $lokasiKosOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasiKosOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lokasiKosOption->id); ?>"><?php echo e($lokasiKosOption->nama_kos); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if(!$lokasiKosOptions->count()): ?>
                            <small class="text-danger">Lokasi Kos tidak tersedia. Harap tambahkan lokasi kos terlebih dahulu.</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" onclick="showSuccessToast()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Skripsi\kost-skripsi\resources\views/kamar/create.blade.php ENDPATH**/ ?>