<div class="modal fade" id="addTransactionModal{{ $roomId }}-{{ $lokasiId }}-{{$penyewaId}}" tabindex="-1" role="dialog"
    aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kamar_id" value="{{ $roomId }}">
                <input type="hidden" name="lokasi_id" value="{{ $lokasiId }}">
                <input type="hidden" name="penyewa_id" value="{{ $penyewaId }}">
                <div class="modal-body">
                    <!-- Tanggal -->
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal_create" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal_create" required>
                    </div>
                    <!-- Jumlah Tarif -->
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah_tarif_create" class="form-label">Jumlah Tarif</label>
                        <input type="text" class="form-control" name="jumlah_tarif" id="jumlah_tarif_create"
                            required onkeyup="formatNumberWithComma(this)">
                    </div>
                    <!-- Tipe Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_pembayaran_create" class="form-label">Tipe Pembayaran</label>
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran_create" required>
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>
                    </div>
                    <!-- Bukti Pembayaran -->
                    <div id="bukti_pembayaran_field_create" style="display: none;">
                        <div class="mb-3 custom-form-group">
                            <label for="bukti_pembayaran_create" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran"
                                id="bukti_pembayaran_create">
                        </div>
                    </div>
                    <!-- Status Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="status_pembayaran_create" class="form-label">Status Pembayaran</label>
                        <select class="form-select" name="status_pembayaran" id="status_pembayaran_create">
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="cicil">Cicil</option>
                        </select>
                    </div>
                    <!-- Tanggal Pembayaran Awal & Akhir -->
                    <div id="tanggal_pembayaran_fields_create" style="display: none;">
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_awal_create" class="form-label">Tanggal Pembayaran
                                Awal</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_awal"
                                id="tanggal_pembayaran_awal_create">
                        </div>
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_pembayaran_akhir_create" class="form-label">Tanggal Pembayaran
                                Akhir</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran_akhir" id="tanggal_pembayaran_akhir_create">
                        </div>
                    </div>
                    <!-- Keterangan Pembayaran -->
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan_create" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan_create">
                    </div>
                    <!-- Add other fields as needed -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tipePembayaranSelect = document.getElementById("tipe_pembayaran_create");
        var statusPembayaranSelect = document.getElementById("status_pembayaran_create");
        var buktiPembayaranField = document.getElementById("bukti_pembayaran_field_create");
        var tanggalPembayaranFields = document.getElementById("tanggal_pembayaran_fields_create");

        function updateVisibility() {
            buktiPembayaranField.style.display = tipePembayaranSelect.value === "non-tunai" ? "block" : "none";
            tanggalPembayaranFields.style.display = statusPembayaranSelect.value === 'cicil' ? 'block' : 'none';
        }

        tipePembayaranSelect.addEventListener("change", updateVisibility);
        statusPembayaranSelect.addEventListener("change", updateVisibility);

        // Initialize the form based on the default selected values
        updateVisibility();
    });

    function formatNumberWithComma(inputField) {
        let input = inputField.value;
        let number = input.replace(/[^0-9]/g, '');
        inputField.value = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>