

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col py-3">
            <a href="<?php echo e(route('kamar.index')); ?>" class="btn btn-secondary mb-3">Kembali</a>
            <form action="<?php echo e(route('kamar.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <div class="mb-3 row">
                        <label for="no_kamar" class="col-sm-2 col-form-label">No Kamar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="no_kamar" id="no_kamar" value="<?php echo e(old('no_kamar')); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="harga" id="harga" value="<?php echo e(old('harga')); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fasilitas" class="col-sm-2 col-form-label">Fasilitas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="<?php echo e(old('fasilitas')); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?php echo e(old('keterangan')); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kost_id" class="col-sm-2 col-form-label">Lokasi Kos</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kost_id" id="kost_id">
                                <option value="">Pilih Lokasi Kos</option>
                                <?php $__currentLoopData = $lokasiKosOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasiKosOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lokasiKosOption->id); ?>"><?php echo e($lokasiKosOption->nama_kos); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\KOST\resources\views/kamar/create.blade.php ENDPATH**/ ?>