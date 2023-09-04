<!-- kamar_table.blade.php -->
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($loop->index + 1); ?></td>
        <td><?php echo e($item->no_kamar); ?></td>
        <td><?php echo e($item->harga); ?></td>
        <td><?php echo e($item->keterangan); ?></td>
        <td><?php echo e($item->fasilitas); ?></td>
        <td>
            <?php if($item->lokasiKos): ?>
                <?php echo e($item->lokasiKos->nama_kos); ?>

            <?php else: ?>
                <span class="text-danger">Lokasi Kos Tidak Tersedia</span>
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
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\kost-skripsi\resources\views/partials/kamar_table.blade.php ENDPATH**/ ?>