

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color: #333;">Dashboard</h3>
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-primary text-white order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Kamar</h6>
                    <h2 class="text-right"><i class="fa fa-bed"></i><span class="ml-2"><?php echo e($totalKamars); ?></span></h2>
                    <p class="m-b-0">Kamar Terisi<span class="float-right"><?php echo e($totalKamarSudahTerisi); ?></span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-success text-white order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Lokasi Kos</h6>
                    <h2 class="text-right"><i class="fa fa-map-marker"></i><span class="ml-2"><?php echo e($totalLokasiKos); ?></span></h2>
                    <p class="m-b-0">Lokasi Kos<span class="float-right"><?php echo e($totalLokasiKos); ?></span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-warning order-card mb-4">
                <div class="card-body">
                    <h6 class="m-b-20">Total Penghuni</h6>
                    <h2 class="text-right"><i class="fa fa-users"></i><span class="ml-2"><?php echo e($totalPenghuni); ?></span></h2>
                    <p class="m-b-0">Penghuni<span class="float-right"><?php echo e($totalPenghuni); ?></span></p>
                </div>
            </div>
        </div>
        
        <!-- Add more cards here if needed -->
        
    </div>
</div>

<!-- Graph Section -->

<script>
    // ... your Chart.js code ...
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\kost-skripsi\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>