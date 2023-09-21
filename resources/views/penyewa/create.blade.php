<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Penyewa</h5>
            </div>
            <form  id="myForm" action="{{ route('penyewa.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Nama Kos (Kost name) Dropdown -->
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Nama Kos</label>
                        <select class="form-select" id="lokasi_id" name="lokasi_id" required>
                            <option value="" disabled selected>Select Nama Kos</option>
                            @foreach ($lokasiKos as $kos)
                                <option value="{{ $kos->id }}">{{ $kos->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No. Kamar (Room number) -->
                    <div class="mb-3 custom-form-group">
                        <label for="no_kamar" class="form-label">No. Kamar</label>
                        <input type="text" class="form-control" name="no_kamar" id="no_kamar" value="{{ old('no_kamar') }}" required>
                        @error('no_kamar')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required>
                    </div>

                    <!-- Jumlah Tarif -->
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_tarif" class="form-label">Jumlah Tarif</label>
                        <input type="text" class="form-control" name="jumlah_tarif" id="jumlah_tarif"
                            value="{{ old('jumlah_tarif') }}" required>
                    </div>

                    <!-- Tipe Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran" required
                        onchange="toggleBuktiPembayaranField()">
                    <option value="tunai">Tunai</option>
                    <option value="non-tunai">Non-Tunai</option>
                </select>
                
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="mb-3 custom-form-group" id="bukti_pembayaran_field" style="display: none;">
                        <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran" accept=".jpg, .png">
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select class="form-select" name="status_pembayaran" id="status_pembayaran" required
                            onchange="toggleTanggalPembayaranFields()">
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="cicil">Cicil</option>
                        </select>
                    </div>

                    <!-- Tanggal Pembayaran Awal and Tanggal Pembayaran Akhir Container -->
                    <div id="tanggal_pembayaran_fields" style="display: none;">
                        <!-- Tanggal Pembayaran Awal -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_awal" class="form-label">Tanggal Pembayaran Awal</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_awal"
                                id="tanggal_pembayaran_awal">
                        </div>

                        <!-- Tanggal Pembayaran Akhir -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_akhir" class="form-label">Tanggal Pembayaran Akhir</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_akhir"
                                id="tanggal_pembayaran_akhir">
                        </div>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status_penyewa">Edit Status Penyewa:</label>
                        <select name="status_penyewa" id="status_penyewa">
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <!-- Keterangan Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan Pembayaran</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" onclick="checkFormAndSubmit()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function checkFormAndSubmit() {
        // Check for validation errors
        if (hasValidationErrors()) {
            // Display an error toast
            showErrorToast();
        } else {
            // Submit the form
            document.getElementById('myForm').submit();
        }
    }

    function hasValidationErrors() {
        // Implement your validation logic here
        // Check if there are any validation errors and return true if errors exist, false otherwise
        // For example, you can check if required fields are empty

        const noKamarField = document.getElementById('no_kamar');
        if (!noKamarField.value.trim()) {
            return true;
        }

        // Add more validation checks as needed

        return false; // Return false if there are no errors
    }

    function showErrorToast() {
        // Display an error toast or message here
        // You can use a library like Bootstrap Toast or any other method to display the error message
        // Example using Bootstrap Toast:
        var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        errorToast.show();
    }

    function showSuccessToast() {
        // Display a success toast or message here
        // You can use a library like Bootstrap Toast or any other method to display the success message
        // Example using Bootstrap Toast:
        var successToast = new bootstrap.Toast(document.getElementById('successToast'));
        successToast.show();
    }

    function toggleBuktiPembayaranField() {
    const tipePembayaran = document.getElementById('tipe_pembayaran').value;
    const buktiPembayaranField = document.getElementById('bukti_pembayaran_field');

    if (tipePembayaran === 'non-tunai') {
        buktiPembayaranField.style.display = 'block'; // Show the field for Non-Tunai
    } else {
        buktiPembayaranField.style.display = 'none'; // Hide the field for Tunai
    }
}

function toggleTanggalPembayaranFields() {
    const statusPembayaran = document.getElementById('status_pembayaran').value;
    const tanggalPembayaranFields = document.getElementById('tanggal_pembayaran_fields');

    if (statusPembayaran === 'cicil') {
        tanggalPembayaranFields.style.display = 'block'; // Show the date fields for Cicil
    } else {
        tanggalPembayaranFields.style.display = 'none'; // Hide the date fields for Lunas dan Belum Lunas
    }
}


</script>