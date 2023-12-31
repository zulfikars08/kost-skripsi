<!-- resources/views/pengeluaran/tambahData_modal.blade.php -->

<!-- Tambah Data Pengeluaran Modal -->
<div class="modal fade" id="tambahDataPemasukanModal" tabindex="-1" role="dialog"
    aria-labelledby="tambahDataPemasukanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataPemasukanModalLabel">Tambah Data Pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <label for="lokasi_id" class="form-label">Lokasi Kos</label>
                        <select class="form-select  @error('lokasi_id') is-invalid @enderror" id="lokasi_id"
                            name="lokasi_id" value="{{ old('lokasi_id') }}" required>
                            <option value="" selected disabled>Pilih Lokasi Kos</option>
                            @foreach($lokasiKos as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_kos }}</option>
                            @endforeach
                        </select>
                        @error('lokasi_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!-- Tambahkan ID ke elemen div yang mengelilingi select "Nomor Kamar" -->
                    <div id="kamarSelectContainer">
                        <div class="mb-3 custom-form-group">
                            <label for="kamar_id" class="form-label">Nomor Kamar</label>
                            <select class="form-select" id="kamar_id" name="kamar_id" required>
                                <option value="" selected disabled>Pilih Nomor Kamar</option>
                                @foreach($kamars as $kamar)
                                <option value="{{ $kamar->id }}" data-lokasi="{{ $kamar->lokasi_id }}">{{ $kamar->no_kamar
                                    }}</option>
                                @endforeach
                                @error('kamar_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran">
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>
                    </div>
                    <div  id="bukti_pembayaran_field" style="display: none;">
                        <div class="mb-3 custom-form-group">
                            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran">
                        </div>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select class="form-select" name="status_pembayaran" id="status_pembayaran" required
                            onchange="toggleTanggalPembayaranFields()">
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                            <option value="cicil">Cicil</option>
                        </select>
                    </div>

                    <div class="mb-3 custom-form-group" id="tanggal_pembayaran_fields" style="display: none;">
                        <label for="tanggal_pembayaran_awal" class="form-label">Tanggal Pembayaran Awal</label>
                        <input type="date" class="form-control" id="tanggal_pembayaran_awal"
                            name="tanggal_pembayaran_awal">

                        <label for="tanggal_pembayaran_akhir" class="form-label">Tanggal Pembayaran Akhir</label>
                        <input type="date" class="form-control" id="tanggal_pembayaran_akhir"
                            name="tanggal_pembayaran_akhir">
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" ></textarea>
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

    // Trigger the change event initially to populate "Nomor Kamar" based on default selection
    lokasiSelect.dispatchEvent(new Event('change'));

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ... your existing script ...

        // Get the element for 'jumlah' input
        const jumlahInput = document.getElementById('jumlah');

        // Format the 'jumlah' input to include commas for thousands
        jumlahInput.addEventListener('input', function (e) {
            // Remove any existing commas
            let value = e.target.value.replace(/,/g, '');

            // Convert the value to a number and then back to a string to remove leading zeros
            value = Number(value).toString();

            // Replace the input value with formatted number
            e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        });
    });
</script>