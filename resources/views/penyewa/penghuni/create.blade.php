<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Penyewa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  id="myForm" action="{{ route('penghuni.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                   
                    <!-- Nama -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required>
                    </div>
                    <!-- Nama -->

                    <!-- Tanggal Lahir -->
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir"
                            id="">
                    </div>
                    <!-- Tanggal Lahir -->

                    <!-- Jenis Kelamin -->
                    <div class="mb-3 custom-form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin">
                            <option value="laki_laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>    
                    <!-- Jenis Kelamin -->   
                    
                    <!-- No Telepon -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="no_telepon" id="no_telepon" 
                        value="{{ old('no_telepon') }}" required>
                    </div>
                    <!-- No Telepon -->

                     <!-- Pekerjaan -->
                     <div class="mb-3 custom-form-group">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" 
                        value="{{ old('pekerjaan') }}" >
                    </div>
                    <!-- Pekerjaan -->

                    <!-- Perusahaan -->
                    <div class="mb-3 custom-form-group">
                        <label for="perusahaan" class="form-label">Perusahaan</label>
                        <input type="text" class="form-control" name="perusahaan" id="perusahaan" 
                        value="{{ old('perusahaan') }}" >
                    </div>
                    <!-- Perusahaan -->

                    <!-- Martial Status -->
                    <div class="mb-3 custom-form-group">
                        <label for="martial_status">Martial Status</label>
                        <select name="martial_status" id="martial_status">
                            <option value="belum_kawin">Belum Kawin</option>
                            <option value="kawin">Kawin</option>
                            <option value="cerai_hidup">Cerai Hidup</option>
                            <option value="cerai_mati">Cerai Mati</option>
                        </select>
                    </div>    
                    <!-- Martial Status -->  


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
