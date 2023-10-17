<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Transaksi</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('transaksi.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Your edit form fields go here -->
                    <!-- Example: -->
                    <!-- Jumlah Tarif -->
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal">
                    </div>

                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_tarif" class="form-label">Jumlah Tarif</label>
                        <input type="text" class="form-control" name="jumlah_tarif" id="jumlah_tarif"
                            value="{{ old('jumlah_tarif') }}" required>
                    </div>

                    <!-- Tipe Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                        <!-- Example for calling the JavaScript function within the loop -->
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran_{{ $item->id }}" required
                            onchange="toggleBuktiPembayaranField({{ $item->id }})">
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>

                    </div>
                    <!-- Bukti Pembayaran -->
                    <div class="mb-3 custom-form-group" id="bukti_pembayaran_field_{{ $item->id }}"
                        style="display: none;">
                        <label for="bukti_pembayaran_{{ $item->id }}" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti_pembayaran"
                            id="bukti_pembayaran_{{ $item->id }}">
                    </div>

                    <!-- Status Pembayaran -->
                    <!-- Example for the 'status_pembayaran' field within the loop -->
                    <div class="mb-3 custom-form-group">
                        <label for="status_pembayaran_{{ $item->id }}" class="form-label">Status Pembayaran</label>
                        <select class="form-select" name="status_pembayaran" id="status_pembayaran_{{ $item->id }}"
                            required onchange="toggleTanggalPembayaranFields({{ $item->id }})">
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="cicil">Cicil</option>
                        </select>
                    </div>

                    <!-- Tanggal Pembayaran Awal and Tanggal Pembayaran Akhir Container (with unique ID) -->
                    <div id="tanggal_pembayaran_fields_{{ $item->id }}" style="display: none;">
                        <!-- Tanggal Pembayaran Awal -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_awal" class="form-label">Tanggal Pembayaran Awal</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_awal"
                                id="tanggal_pembayaran_awal_{{ $item->id }}">
                        </div>

                        <!-- Tanggal Pembayaran Akhir -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_akhir" class="form-label">Tanggal Pembayaran Akhir</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_akhir"
                                id="tanggal_pembayaran_akhir_{{ $item->id }}">
                        </div>
                    </div>

                    <div class="mb-3 custom-form-group">
                        <label for="kebersihan" class="form-label">Kebersihan</label>
                        <input type="number" class="form-control" name="kebersihan" id="kebersihan"
                            value="{{ $item->kebersihan }}" required>
                    </div>

                    <!-- Pengeluaran -->
                    {{-- <div class="mb-3 custom-form-group">
                        <label for="pengeluaran" class="form-label">Pengeluaran</label>
                        <input type="number" class="form-control" name="pengeluaran" id="pengeluaran"
                            value="{{ $item->pengeluaran }}" required>
                    </div> --}}

                    <!-- Keterangan Pembayaran -->
                    {{-- <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" required>
                    </div> --}}
                    <!-- Add other fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('tipe_pembayaran').addEventListener('change', toggleBuktiPembayaranField);
document.getElementById('status_pembayaran').addEventListener('change', toggleTanggalPembayaranFields);

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
    function toggleBuktiPembayaranField(transactionId) {
    const tipePembayaran = document.getElementById(`tipe_pembayaran_${transactionId}`).value;
    const buktiPembayaranField = document.getElementById(`bukti_pembayaran_field_${transactionId}`);
    if (tipePembayaran === 'non-tunai') {
        buktiPembayaranField.style.display = 'block'; // Show the field for Non-Tunai
    } else {
        buktiPembayaranField.style.display = 'none'; // Hide the field for Tunai
    }
}


function toggleTanggalPembayaranFields(transactionId) {
    const statusPembayaran = document.getElementById(`status_pembayaran_${transactionId}`).value;
    const tanggalPembayaranFields = document.getElementById(`tanggal_pembayaran_fields_${transactionId}`);
    if (statusPembayaran === 'cicil') {
        tanggalPembayaranFields.style.display = 'block'; // Show the date fields for Cicil
    } else {
        tanggalPembayaranFields.style.display = 'none'; // Hide the date fields for Lunas dan Belum Lunas
    }
}



</script>