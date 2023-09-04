

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="<?php echo e(url('kamar')); ?>" class="btn btn-secondary mb-3">Kembali</a>
            <form action="<?php echo e(url('kamar/'.$data->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label for="no_kamar" class="form-label">No kamar</label>
                    <input type="text" class="form-control" id="no_kamar" value="<?php echo e($data->no_kamar); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga" value="<?php echo e($data->harga); ?>">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo e($data->keterangan); ?>">
                </div>
                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="<?php echo e($data->fasilitas); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\KOST\resources\views/kamar/edit.blade.php ENDPATH**/ ?>