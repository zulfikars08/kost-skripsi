<!-- transaksi.filter.blade.php -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('pengeluaran.index')); ?>" method="GET">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="filterNamaKos">Nama Kos</label>
                        <select class="form-control" id="filterNamaKos" name="nama_kos">
                            <option value="">Pilih Lokasi Kos</option>
                            <?php $__currentLoopData = $lokasiKos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasiKosOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lokasiKosOption->nama_kos); ?>"><?php echo e($lokasiKosOption->nama_kos); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterBulan">Bulan</label>
                        <select class="form-control" id="filterBulan" name="bulan">
                            <option value="">Pilih Bulan</option>
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthValue => $monthName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($monthValue); ?>"><?php echo e($monthName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterTahun">Tahun</label>
                        <select class="form-control" id="filterTahun" name="tahun">
                            <option value="">Pilih Tahun</option>
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <!-- Add options for years -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterTipePembayaran">Tipe Pembayaran</label>
                        <select class="form-control" id="filterTipePembayaran" name="tipe_pembayaran">
                            <option value="">Pilih Tipe Pembayaran</option>
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non Tunai</option>
                        </select>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between mb-3">
                        <button type="submit" class="btn btn-primary" id="filter-button">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filter-form');
        const namaKos = document.getElementById('filterNamaKos');
        const bulan = document.getElementById('filterBulan');
        const tahun = document.getElementById('filterTahun');
        const tipePembayaran = document.getElementById('filterTipePembayaran');
        const resetButton = document.getElementById('reset-button');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting

            const queryParams = [];

            if (namaKos.value) {
                queryParams.push(`nama_kos=${namaKos.value}`);
            }
            if (bulan.value) {
                queryParams.push(`bulan=${bulan.value}`);
            }
            if (tahun.value) {
                queryParams.push(`tahun=${tahun.value}`);
            }
            if (tipePembayaran.value) {
                queryParams.push(`tipe_pembayaran=${tipePembayaran.value}`);
            }

            const url = "<?php echo e(route('transaksi.index')); ?>";
            window.location.href = url + (queryParams.length > 0 ? '?' + queryParams.join('&') : '');
        });
    });
</script>
<?php /**PATH C:\skripsi\kost-skripsi\resources\views/pemasukan/filter.blade.php ENDPATH**/ ?>