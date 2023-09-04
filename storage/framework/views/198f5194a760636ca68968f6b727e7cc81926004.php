

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- ... Other HTML content ... -->
    <div class="pb-3">
        <!-- SEARCH FORM -->
        <form class="d-flex" action="<?php echo e(route('kamar.index')); ?>" method="get">
            <input class="form-control me-1" type="search" name="katakunci" value="<?php echo e(Request::get('katakunci')); ?>" placeholder="Masukkan kata kunci" aria-label="Search">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </form>
    </div>

    <div class="pb-3">
        <!-- ADD NEW DATA BUTTON -->
        <a href="<?php echo e(url('kamar/create')); ?>" class="btn btn-primary">+ Tambah Data</a>
    </div>
    
    <!-- ROOMS LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">No_Kamar</th>
                <th class="col-md-3">Harga</th>
                <th class="col-md-4">Keterangan</th>
                <th class="col-md-2">Fasilitas</th>
                <th class="col-md-2">Lokasi Kos</th>
                <th class="col-md-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($data->firstItem() + $loop->index); ?></td>
                    <td><?php echo e($item->no_kamar); ?></td>
                    <td><?php echo e($item->harga); ?></td>
                    <td><?php echo e($item->keterangan); ?></td>
                    <td><?php echo e($item->fasilitas); ?></td>
                    <td>
                        <?php if($kamars[$key]->lokasiKos): ?>
                            <?php echo e($kamars[$key]->lokasiKos->nama_kos); ?>

                        <?php else: ?>
                            No Lokasi
                        <?php endif; ?>
                    </td>
                    <td class="d-flex">
                        <div class="btn-group" role="group">
                            <a href="<?php echo e(route('kamar.edit', $item->id)); ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline" action="<?php echo e(route('kamar.destroy', $item->id)); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" name="submit" class="btn btn-danger btn-sm me-2">Delete</button>
                            </form>
                            <a href="<?php echo e(route('kamar.detail', $item->id)); ?>" class="btn btn-success btn-sm">Detail</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">No data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo e($data->withQueryString()->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\KOST\resources\views/kamar/index.blade.php ENDPATH**/ ?>