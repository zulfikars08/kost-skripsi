

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Kamar</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm" >
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="<?php echo e(route('kamar.index')); ?>" method="get" id="search-form">
                <div class="input-group">
                    <label class="input-group-text search-input" for="search-input">Search</label>
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci" aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            <?php echo $__env->make('kamar.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Include the modal partial -->



        </div>
    </div>



    <!-- ROOMS LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No Kamar</th>
                <th>Harga</th>
                <th>Fasilitas</th>
                <th>Keterangan</th>
                <th>
                    <!-- Filter by Lokasi Kos dropdown here -->
                    <div class="dropdown">
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="lokasiDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lokasi Kos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="lokasiDropdown">
                            <form action="<?php echo e(route('kamar.index')); ?>" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="filter_by_lokasi" id="lokasiKos">
                                        <option value="">Semua Lokasi Kos</option>
                                        <?php $__currentLoopData = $lokasiKosOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasiKosOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lokasiKosOption->nama_kos); ?>"><?php echo e($lokasiKosOption->nama_kos); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="modal-footer px-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </th>
                <!-- Filter by Status dropdown here -->
                <th>
                    <div class="dropdown">
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="statusDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Status
                        </a>
                        <div class="dropdown-menu" aria-labelledby="statusDropdown">
                            <form action="<?php echo e(route('kamar.index')); ?>" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="filter_by_status" id="filterByStatus">
                                        <option value="">Semua Status</option>
                                        <option value="belum terisi" <?php echo e(request('filter_by_status')==='belum terisi' ? 'selected' : ''); ?>>Belum Terisi</option>
                                        <option value="sudah terisi" <?php echo e(request('filter_by_status')==='sudah terisi' ? 'selected' : ''); ?>>Sudah Terisi</option>
                                    </select>
                                </div>
                                <div class="modal-footer px-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </th>
                
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $filteredKamarData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e(($filteredKamarData->currentPage() - 1) * $filteredKamarData->perPage() + $loop->iteration); ?></td>
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
                        <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($item->id); ?>">
                            Edit
                        </button>
                        <?php echo $__env->make('kamar.edit', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                            action="<?php echo e(route('kamar.destroy', $item->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" name="submit" class="btn btn-danger btn-sm me-2" onclick="showSuccessToast()">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8">Tidak ada data.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        
        
    </table>
        <?php echo e($filteredKamarData->appends(request()->except('page'))->links()); ?>



    
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\kost-skripsi\resources\views/kamar/index.blade.php ENDPATH**/ ?>