<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Lokasi Kos</h5>
            </div>
            <form action="<?php echo e(route('lokasi_kos.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Nama Kos -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama_kos" class="form-label">Nama Kos</label>
                        <input type="text" class="form-control" name="nama_kos" id="nama_kos" value="<?php echo e(old('nama_kos')); ?>" required>
                        <?php $__errorArgs = ['nama_kos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger">Nama Kos sudah digunakan</div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <!-- Jumlah Kamar -->
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                        <input type="text" class="form-control" name="jumlah_kamar" id="jumlah_kamar" value="<?php echo e(old('jumlah_kamar')); ?>" required>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="mb-3 custom-form-group">
                        <label for="alamat_kos" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat_kos" id="alamat_kos" value="<?php echo e(old('alamat_kos')); ?>" required>
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
<?php /**PATH C:\kost-skripsi\resources\views/lokasi_kos/create.blade.php ENDPATH**/ ?>