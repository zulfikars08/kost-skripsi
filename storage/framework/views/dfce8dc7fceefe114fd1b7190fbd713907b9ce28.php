<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Lokasi Kos</h5>
            </div>
            <form action="<?php echo e(route('penghuni.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Nama -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?php echo e(old('nama')); ?>" required>
                    </div>
                    
                    <!-- Jenis Kelamin -->
                    <div class="mb-3 custom-form-group">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <!-- No HP -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="<?php echo e(old('no_hp')); ?>" required>
                    </div>

                    <!-- Pekerjaan -->
                    <div class="mb-3 custom-form-group">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <select class="form-select" name="pekerjaan" id="pekerjaan" required>
                            <option value="PNS" <?php echo e(old('pekerjaan') === 'PNS' ? 'selected' : ''); ?>>PNS</option>
                            <option value="Guru/Dosen" <?php echo e(old('pekerjaan') === 'Guru/Dosen' ? 'selected' : ''); ?>>Guru/Dosen</option>
                            <option value="Pegawai Swasta" <?php echo e(old('pekerjaan') === 'Pegawai Swasta' ? 'selected' : ''); ?>>Pegawai Swasta</option>
                            <option value="Pengusaha" <?php echo e(old('pekerjaan') === 'Pengusaha' ? 'selected' : ''); ?>>Pengusaha</option>
                            <option value="Pengacara/Hakim/Jaksa/Notaris" <?php echo e(old('pekerjaan') === 'Pengacara/Hakim/Jaksa/Notaris' ? 'selected' : ''); ?>>Pengacara/Hakim/Jaksa/Notaris</option>
                            <option value="Dokter/Bidan/Perawat" <?php echo e(old('pekerjaan') === 'Dokter/Bidan/Perawat' ? 'selected' : ''); ?>>Dokter/Bidan/Perawat</option>
                            <option value="Pedagang" <?php echo e(old('pekerjaan') === 'Pedagang' ? 'selected' : ''); ?>>Pedagang</option>
                            <option value="Buruh" <?php echo e(old('pekerjaan') === 'Buruh' ? 'selected' : ''); ?>>Buruh</option>
                            <option value="Sopir/Masinis/Kondektur" <?php echo e(old('pekerjaan') === 'Sopir/Masinis/Kondektur' ? 'selected' : ''); ?>>Sopir/Masinis/Kondektur</option>
                            <option value="Lainnya" <?php echo e(old('pekerjaan') === 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="mb-3 custom-form-group" id="pekerjaan-lainnya" style="display: none;text-align: start">
                        <label for="pekerjaan_lainnya" class="form-label">Pekerjaan Lainnya</label>
                        <input type="text" class="form-control" name="pekerjaan_lainnya" id="pekerjaan_lainnya" value="<?php echo e(old('pekerjaan_lainnya')); ?>">
                    </div>
                    
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const pekerjaanDropdown = document.getElementById("pekerjaan");
                            const pekerjaanLainnya = document.getElementById("pekerjaan-lainnya");
                    
                            pekerjaanDropdown.addEventListener("change", function() {
                                if (this.value === "Lainnya") {
                                    pekerjaanLainnya.style.display = "block";
                                } else {
                                    pekerjaanLainnya.style.display = "none";
                                }
                            });
                    
                            // Set tampilan awal saat halaman dimuat
                            if (pekerjaanDropdown.value === "Lainnya") {
                                pekerjaanLainnya.style.display = "block";
                            } else {
                                pekerjaanLainnya.style.display = "none";
                            }
                        });
                    </script>

                    <!-- Perusahaan -->
                    <div class="mb-3 custom-form-group">
                        <label for="perusahaan" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control" name="perusahaan" id="perusahaan" value="<?php echo e(old('perusahaan')); ?>" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo e(old('tanggal_lahir')); ?>" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" onclick="showSuccessToast()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\kost-skripsi\resources\views/penghuni/create.blade.php ENDPATH**/ ?>