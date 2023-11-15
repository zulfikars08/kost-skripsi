<!-- Delete Modal -->
<div class="modal fade" id="deleteModal<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus baris ini?
            </div>
            <div class="modal-footer">
                <form action="<?php echo e(route('pengeluaran.destroy', ['id' => $item->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\skripsi\kost-skripsi\resources\views/pengeluaran/delete.blade.php ENDPATH**/ ?>