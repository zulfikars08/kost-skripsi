{{-- <!-- resources/views/pemasukan/edit.blade.php -->

<!-- Edit Data Pemasukan Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                    <div class="modal-body">
                <!-- Add your form fields here -->
                <form action="{{ route('pemasukan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Nama Kos</label>
                        <select class="form-select" id="lokasi_id" name="lokasi_id" required>
                            <option value="" selected disabled>Pilih Nama Kos</option>
                            @foreach($lokasiKos as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tambahkan ID ke elemen div yang mengelilingi select "Nomor Kamar" -->
                    <div class="mb-3 custom-form-group" id="kamarSelectContainer">
                        <label for="kamar_id" class="form-label">Nomor Kamar</label>
                        <select class="form-select" id="kamar_id" name="kamar_id" required>
                            <option value="" selected disabled>Pilih Nomor Kamar</option>
                            @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id }}" data-lokasi="{{ $kamar->lokasi_id }}">{{ $kamar->no_kamar
                                }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                        <!-- Example for calling the JavaScript function within the loop -->
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran_{{ $item->id }}" required
                            onchange="toggleBuktiPembayaranField({{ $item->id }})">
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>

                    </div>
                    <div class="mb-3 custom-form-group" id="bukti_pembayaran_field_{{ $item->id }}"
                        style="display: none;">
                        <label for="bukti_pembayaran_{{ $item->id }}" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti_pembayaran"
                            id="bukti_pembayaran_{{ $item->id }}">
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                    <!-- Add other form fields as needed -->
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </form>
            </div>
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



</script> --}}