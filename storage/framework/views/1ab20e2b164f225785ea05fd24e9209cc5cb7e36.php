<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/sidebar.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/search.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/dashboard.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/all.min.css')); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div class="sidebar">
                <a href="#" class="nav_logo">
                    <i class="fas fa-layer-group nav_logo-icon"></i>
                    <span class="nav_logo-name">ADMIN</span>
                </a>
                <div class="nav_list">
                    <div class="nav_item">
                        <a href="/dashboard" class="nav_link active">
                            <i class="fas fa-th nav_icon"></i>
                            <span class="nav_name">Dashboard</span>
                        </a>
                    </div>
                    <div class="nav_item">
                        <a href="/kamar" class="nav_link">
                            <i class="fas fa-map-marker-alt nav_icon"></i>
                            <span class="nav_name">Data Lokasi</span>
                        </a>
                    </div>
                    <div class="nav_item">
                        <a href="#" class="nav_link">
                            <i class="fas fa-bed nav_icon"></i>
                            <span class="nav_name">Data Kamar</span>
                        </a>
                    </div>
                    <div class="nav_item">
                        <a href="#" class="nav_link">
                            <i class="fas fa-users nav_icon"></i>
                            <span class="nav_name">Data Penghuni</span>
                        </a>
                    </div>
                    <div class="nav_item">
                        <a href="#" class="nav_link">
                            <i class="fas fa-user-friends nav_icon"></i>
                            <span class="nav_name">Data Penyewa</span>
                        </a>
                    </div>
                </div>
                <a href="#" class="nav_link">
                    <i class="fas fa-sign-out-alt nav_icon"></i>
                    <span class="nav_name">Log out</span>
                </a>
            </div>            
            </div>
    </div>

    </nav>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId);

                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        nav.classList.toggle('show');
                        toggle.classList.toggle('bx-x');
                        bodypd.classList.toggle('body-pd');
                        headerpd.classList.toggle('body-pd');
                    });
                }
            }

            showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');
        });
    </script>
    <div class="centered-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>

</html><?php /**PATH C:\Skripsi\kost-skripsi\resources\views/layout/template.blade.php ENDPATH**/ ?>