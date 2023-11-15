<!-- resources/views/pengeluaran/tambahData_modal.blade.php -->

<!-- Tambah Data Pengeluaran Modal -->
<div class="modal fade" id="tambahDataPemasukanModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataPemasukanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataPemasukanModalLabel">Tambah Data Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields here -->
                <form action="{{ route('pemasukan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
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
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran">
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group" id="bukti_pembayaran_field" style="display: none;">
                        <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran">
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
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil elemen select "Nama Kos" dan "Nomor Kamar"
        const lokasiSelect = document.getElementById("lokasi_id");
        const kamarSelect = document.getElementById("kamar_id");
        const kamarSelectContainer = document.getElementById("kamarSelectContainer");

        // Simpan semua opsi nomor kamar ke dalam sebuah objek JavaScript
        const kamarOptions = {!! json_encode($kamars->keyBy('id')->map->only('lokasi_id', 'no_kamar')) !!};

        // Tambahkan event listener ketika pemilihan "Nama Kos" berubah
        lokasiSelect.addEventListener("change", function () {
            const selectedLokasiId = lokasiSelect.value;

            // Kosongkan opsi nomor kamar terlebih dahulu
            kamarSelect.innerHTML = '<option value="" selected disabled>Pilih Nomor Kamar</option>';

            // Tampilkan hanya opsi nomor kamar yang sesuai dengan "Nama Kos" yang dipilih
            Object.keys(kamarOptions).forEach((kamarId) => {
                if (kamarOptions[kamarId].lokasi_id == selectedLokasiId) {
                    const option = document.createElement("option");
                    option.value = kamarId;
                    option.textContent = kamarOptions[kamarId].no_kamar;
                    kamarSelect.appendChild(option);
                }
            });

            // Tampilkan atau sembunyikan select "Nomor Kamar" berdasarkan pilihan "Nama Kos"
            if (selectedLokasiId) {
                kamarSelectContainer.style.display = "block";
            } else {
                kamarSelectContainer.style.display = "none";
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add event listeners to tipe_pembayaran and status_pembayaran
        document.getElementById('tipe_pembayaran').addEventListener('change', toggleBuktiPembayaranField);
        document.getElementById('status_pembayaran').addEventListener('change', toggleTanggalPembayaranFields);
    });

    function toggleBuktiPembayaranField() {
        const tipePembayaran = document.getElementById('tipe_pembayaran').value;
        const buktiPembayaranField = document.getElementById('bukti_pembayaran_field');

        buktiPembayaranField.style.display = (tipePembayaran === 'non-tunai') ? 'block' : 'none';
    }

    function toggleTanggalPembayaranFields() {
        const statusPembayaran = document.getElementById('status_pembayaran').value;
        const tanggalPembayaranFields = document.getElementById('tanggal_pembayaran_fields');

        tanggalPembayaranFields.style.display = (statusPembayaran === 'cicil') ? 'block' : 'none';
    }
</script>
