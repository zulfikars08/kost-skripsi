

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('komponen.pesan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Penghuni</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="<?php echo e(route('penghuni.index')); ?>" method="get" id="search-form">
                <div class="input-group">
                    <label class="input-group-text search-input" for="search-input">Search</label>
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>
            <script>
                $(document).ready(function() {
                    // Original data (you can replace this with your actual data)
                    var originalData = [
                        { name: "Item 1", value: "value1" },
                        { name: "Item 2", value: "value2" },
                        // ... more data ...
                    ];
                
                    // Populate the autocomplete suggestions
                    function populateAutocomplete(data) {
                        $("#search-input").autocomplete({
                            source: data.map(item => item.name),
                            select: function(event, ui) {
                                // Handle selection
                                // You can find the selected item value using ui.item.value
                            }
                        });
                    }
                
                    // Initialize autocomplete with original data
                    populateAutocomplete(originalData);
                
                    // Clear search input and revert to original data
                    $("#clear-button").click(function() {
                        $("#search-input").val("");
                        populateAutocomplete(originalData);
                    });
                });
            </script>



            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            <?php echo $__env->make('penghuni.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- Include the modal partial -->



        </div>
    </div>
    

    <!-- LOKASI_KOS LIST TABLE -->
   <!-- LOKASI_KOS LIST TABLE -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>No HP</th>
            <th>Pekerjaan</th>
            <th>Perusahaan</th>
            <th>Tanggal Lahir</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = $data->firstItem();
        ?>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($i); ?></td>
            <!-- Nama -->
            <td><?php echo e($item->nama); ?></td>
            <!-- Jenis Kelamin -->
            <td><?php echo e($item->jenis_kelamin); ?></td>
            <!-- No HP -->
            <td><?php echo e($item->no_hp); ?></td>
            <!-- Pekerjaan -->
            <td>
                <?php if($item->pekerjaan === 'Lainnya'): ?>
                    <?php echo e($item->pekerjaan_lainnya); ?>

                <?php else: ?>
                    <?php echo e($item->pekerjaan); ?>

                <?php endif; ?>
            </td>
            <!-- Perusahaan -->
            <td><?php echo e($item->perusahaan); ?></td>
            <!-- Tanggal Lahir -->
            <td><?php echo e($item->tanggal_lahir); ?></td>
            <!-- Status -->
            <td><?php echo e($item->status); ?></td>
            <td>
                <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                    action="<?php echo e(route('lokasi_kos.destroy', $item->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
                <a href="<?php echo e(route('lokasi_kos.detail', $item->id)); ?>" class="btn btn-success btn-sm">Detail</a>
            </td>
        </tr>
        <?php
        $i++;
        ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php echo e($data->withQueryString()->links()); ?>


</div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\kost-skripsi\resources\views/penghuni/index.blade.php ENDPATH**/ ?>