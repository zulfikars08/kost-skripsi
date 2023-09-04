

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h3 class="text-start mb-4" style="font-family: 'Lato', sans-serif">Dashboard</h3>
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Kamar</h6>
                    <h2 class="text-right"><i class="fa fa-bed f-left"></i><span><?php echo e($totalKamars); ?></span></h2>
                    <p class="m-b-0">Kamar Terisi<span class="f-right"><?php echo e($totalKamarSudahTerisi); ?></span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Lokasi Kos</h6>
                    <h2 class="text-right"><i class="fa fa-map-marker f-left"></i><span><?php echo e($totalLokasiKos); ?></span></h2>
                    <p class="m-b-0">Lokasi Kos<span class="f-right"><?php echo e($totalLokasiKos); ?></span></p>
                </div>
            </div>
        </div>
        
        <!-- Add more cards here if needed -->
        
    </div>

    <!-- Graph Section -->

<script>
    // ... your Chart.js code ...
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Skripsi\kost-skripsi\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>