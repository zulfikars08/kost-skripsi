<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran_{{ $item->id }}" required>
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="mb-3 custom-form-group" id="bukti_pembayaran_field_{{ $item->id }}" style="display: none;">
                        <label for="bukti_pembayaran_{{ $item->id }}" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti_pembayaran"
                            id="bukti_pembayaran_{{ $item->id }}">
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="status_pembayaran_{{ $item->id }}" class="form-label">Status Pembayaran</label>
                        <select class="form-select" name="status_pembayaran" id="status_pembayaran_{{ $item->id }}">
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="cicil">Cicil</option>
                        </select>
                    </div>

                    <!-- Tanggal Pembayaran Awal and Tanggal Pembayaran Akhir Container (with unique ID) -->
                    <div id="tanggal_pembayaran_fields_{{ $item->id }}" style="display: none;">
                        <!-- Tanggal Pembayaran Awal -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_awal_{{ $item->id }}" class="form-label">Tanggal Pembayaran Awal</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_awal"
                                id="tanggal_pembayaran_awal_{{ $item->id }}">
                        </div>

                        <!-- Tanggal Pembayaran Akhir -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_akhir_{{ $item->id }}" class="form-label">Tanggal Pembayaran Akhir</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_akhir"
                                id="tanggal_pembayaran_akhir_{{ $item->id }}">
                        </div>
                    </div>

                    <!-- Keterangan Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" required>
                    </div>
                    <!-- Add other fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for showing/hiding fields based on payment type -->
<!-- JavaScript for showing/hiding fields based on payment type and status -->
<!-- JavaScript for showing/hiding fields based on payment type and status -->
<!-- JavaScript for showing/hiding fields based on payment type and status -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tipePembayaranSelect = document.getElementById("tipe_pembayaran_{{ $item->id }}");
        var statusPembayaranSelect = document.getElementById("status_pembayaran_{{ $item->id }}");
        var buktiPembayaranField = document.getElementById("bukti_pembayaran_field_{{ $item->id }}");
        var tanggalPembayaranFields = document.getElementById("tanggal_pembayaran_fields_{{ $item->id }}");

        function updateVisibility() {
            if (tipePembayaranSelect.value === "non-tunai") {
                buktiPembayaranField.style.display = "block";
            } else {
                buktiPembayaranField.style.display = "none";
            }

            if (statusPembayaranSelect.value === 'cicil') {
                tanggalPembayaranFields.style.display = 'block';
            } else {
                tanggalPembayaranFields.style.display = 'none';
            }
        }

        tipePembayaranSelect.addEventListener("change", updateVisibility);
        statusPembayaranSelect.addEventListener("change", updateVisibility);

        // Trigger the change event to initialize the form based on the default selected values
        tipePembayaranSelect.dispatchEvent(new Event("change"));
        statusPembayaranSelect.dispatchEvent(new Event("change"));
    });
</script>

