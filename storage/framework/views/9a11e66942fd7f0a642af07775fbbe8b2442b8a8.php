

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Navigation Sidebar -->
    

        <!-- Main Content Area -->
        <div class="col py-3">
            <?php if($errors->any()): ?>
            <div class="pt-3">
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Welcome Message -->
            <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                <h1>Selamat datang</h1>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\KOST\resources\views/home.blade.php ENDPATH**/ ?>