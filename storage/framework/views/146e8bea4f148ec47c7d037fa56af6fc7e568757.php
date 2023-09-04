

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col py-3">
            <a href="<?php echo e(url('lokasi_kos')); ?>" class="btn btn-secondary mb-3">Kembali</a>
            <form action="<?php echo e(url('lokasi_kos')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <div class="mb-3 row">
                        <label for="nama_kos" class="col-sm-2 col-form-label">Nama Kos</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_kos" id="nama_kos" value="<?php echo e(old('nama_kos', Session::get('nama_kos'))); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah_kamar" class="col-sm-2 col-form-label">Jumlah Kamar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jumlah_kamar" id="jumlah_kamar" value="<?php echo e(old('jumlah_kamar', Session::get('jumlah_kamar'))); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat_kos" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="alamat_kos" id="alamat_kos" value="<?php echo e(old('alamat_kos', Session::get('alamat'))); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\KOST\resources\views/lokasi_kos/create.blade.php ENDPATH**/ ?>