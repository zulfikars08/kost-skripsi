<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css">

</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
      <!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active centered-text" href="/home">
                    <b class="bi bi-speedometer2 me-2"></b> Admin
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-file-earmark-text me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/lokasi_kos">
                    <i class="bi bi-file-earmark-text me-2"></i> Data Kos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kamar">
                    <i class="bi bi-person me-2"></i> Data Kamar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#submenu" data-bs-toggle="collapse">
                    <i class="bi bi-list me-2"></i> Penghuni dan Penyewa
                </a>
                <div class="collapse" id="submenu">
                    <ul class="nav flex-column pl-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Data Penghuni</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Data Penyewa</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>

        
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="centered-content">
                <!-- ... Main content here ... -->
                <?php echo $__env->make('komponen.pesan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
        
        
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

<!-- Custom JavaScript (if any) -->
<script src="/path/to/custom.js"></script>
</body>
</html>
<?php /**PATH C:\KOST\resources\views/layout/template.blade.php ENDPATH**/ ?>