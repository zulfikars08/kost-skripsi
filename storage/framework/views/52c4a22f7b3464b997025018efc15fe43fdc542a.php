

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col py-3">
            <?php if($errors->any()): ?>
            <div class="pt-3">
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($item); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="pb-3">
                    <!-- SEARCH FORM -->
                    <form class="d-flex" action="<?php echo e(url('lokasi_kos')); ?>" method="get">
                        <input class="form-control me-1" type="search" name="katakunci" value="<?php echo e(Request::get('katakunci')); ?>" placeholder="Masukkan kata kunci" aria-label="Search">
                        <button class="btn btn-secondary" type="submit">Cari</button>
                    </form>
                </div>

                <div class="pb-3">
                    <!-- ADD NEW DATA BUTTON -->
                    <a href="<?php echo e(url('lokasi_kos/create')); ?>" class="btn btn-primary">+ Tambah Data</a>
                </div>

                <!-- ROOMS LIST TABLE -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kos</th>
                            <th>Jumlah Kamar</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = $data->firstItem();
                        ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($item->nama_kos); ?></td>
                            <td><?php echo e($item->jumlah_kamar); ?></td>
                            <td><?php echo e($item->alamat_kos); ?></td>
                            <td>
                                <a href="<?php echo e(url('lokasi_kos/'.$item->id.'/edit')); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline" action="<?php echo e(url('lokasi_kos/'.$item->id)); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <a href="<?php echo e(url('lokasi_kos/'.$item->id.'/detail')); ?>" class="btn btn-success btn-sm">Detail</a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($data->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\KOST\resources\views/lokasi_kos/index.blade.php ENDPATH**/ ?>