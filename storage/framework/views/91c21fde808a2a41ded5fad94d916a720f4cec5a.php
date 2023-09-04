

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="mb-3 text-start">
                <a href="<?php echo e(url('lokasi_kos')); ?>" class="btn btn-secondary mb-3 s">Kembali</a>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white text-start">
                    <h4 class="mb-0">Detail Lokasi</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-info text-white">Lokasi kos</th>
                            <td><?php echo e($lokasiKos->nama_kos); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-info text-white">Jumlah Kamar</th>
                            <td><?php echo e($lokasiKos->jumlah_kamar); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-info text-white">Alamat</th>
                            <td><?php echo e($lokasiKos->alamat_kos); ?></td>
                        </tr>
                    </table>

                    <h5 class="mt-4">Daftar Kamar:</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Kamar</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $lokasiKos->kamars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kamar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($kamar->no_kamar); ?></td>
                                <td>Rp<?php echo e(number_format($kamar->harga, 2)); ?></td>
                                <td><?php echo e($kamar->keterangan); ?></td>
                                <td><?php echo e($kamar->fasilitas); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-muted">Tidak ada kamar tersedia.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\kost-skripsi\resources\views/lokasi_kos/detail.blade.php ENDPATH**/ ?>