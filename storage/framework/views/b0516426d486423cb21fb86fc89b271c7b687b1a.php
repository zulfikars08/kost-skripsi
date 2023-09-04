<?php $__empty_1 = true; $__currentLoopData = $filteredKamarData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr>
    <td><?php echo e($loop->iteration); ?></td>
    <td><?php echo e($item->no_kamar); ?></td>
    <td><?php echo e($item->harga); ?></td>
    <td><?php echo e($item->fasilitas); ?></td>
    <td><?php echo e($item->keterangan); ?></td>
    <td><?php echo e($item->lokasiKos->nama_kos); ?></td>
    <td>
        <?php if($item->status === 'belum terisi' || $item->status == NULL): ?>
        <button class="btn btn-status btn-danger"><?php echo e($item->status); ?></button>
        <?php else: ?>
        <button class="btn btn-status btn-success"><?php echo e($item->status); ?></button>
        <?php endif; ?>
    </td>

    <td>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                data-bs-target="#editModal<?php echo e($item->id); ?>">
                Edit
            </button>
            <?php echo $__env->make('kamar.edit', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                action="<?php echo e(route('kamar.destroy', $item->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" name="submit" class="btn btn-danger btn-sm me-2"
                    onclick="showSuccessToast()">Delete</button>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="7">Tidak ada data.</td>
</tr>
<?php endif; ?>
<?php /**PATH C:\kost-skripsi\resources\views/kamar/table.blade.php ENDPATH**/ ?>