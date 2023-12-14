<!-- Edit Modal -->
<div class="modal fade" id="editDataModal{{ $item->id }}" tabindex="-1"
    aria-labelledby="editDataModal{{ $item->id }}Label" aria-hidden="true">
    <div class="modal-dialog custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $item->id }}Label">Edit Data Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Your edit form goes here -->
                <form action="{{ route('laporan-keuangan.update', $item->id) }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Kode Laporan -->
                        <div class="col-md-6">
                            <div class="mb-3 custom-form-group">
                                <label for="kode_laporan" class="form-label">Kode Laporan</label>
                                <input type="text" class="form-control" id="kode_laporan" name="kode_laporan"
                                    value="{{ $item->kode_laporan }}" disabled>
                            </div>
                        </div>
                        <!-- Tanggal -->
                        <div class="col-md-6">
                            <div class="mb-3 custom-form-group">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $item->tanggal }}" required>
                            </div>
                        </div>
                        <!-- Nama Kos -->
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_kos" class="form-label">Nama Kos</label>
                                <input type="text" class="form-control" id="nama_kos" name="nama_kos"
                                    value="{{ $item->lokasi->nama_kos }}" required>
                            </div>
                        </div> --}}
                        <!-- Tipe Pembayaran -->
                        <div class="col-md-6">
                            <div class="mb-3 custom-form-group">
                                <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                                <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran_{{ $item->id }}"
                                    required onchange="toggleBuktiPembayaranField({{ $item->id }})">
                                    <option value="tunai">Tunai</option>
                                    <option value="non-tunai">Non-Tunai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="bukti_pembayaran_field_{{ $item->id }}" style="display: none;">
                            <div class="mb-3 custom-form-group">
                                <label for="bukti_pembayaran_{{ $item->id }}" class="form-label">Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="bukti_pembayaran"
                                    id="bukti_pembayaran_{{ $item->id }}">
                            </div>
                        </div>
                        <!-- Jenis -->
                        <div class="col-md-6">
                            <div class="mb-3 custom-form-group">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select" id="jenis_{{ $item->id }}" name="jenis"
                                    onchange="toggleJenisFields({{ $item->id }})" required>
                                    <option value="pemasukan" {{ $item->jenis === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                    <option value="pengeluaran" {{ $item->jenis === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                </select>
                            </div>
                        </div>
                        <!-- Jumlah Pemasukan -->
                        <div class="col-md-6" id="pemasukanField_{{ $item->id }}" style="display: none;">
                            <div class="mb-3 custom-form-group"">
                                <label for="pemasukan" class="form-label">Jumlah Pemasukan</label>
                                <input type="text" class="form-control" id="pemasukan_{{ $item->id }}" name="pemasukan"
                                    value="{{ number_format($item->jumlah, 0, ',', ',') }}" required 
                                    onkeyup="formatNumberWithComma(this)">
                            </div>
                        </div>
                        <!-- Jumlah Pengeluaran -->
                        <div class="col-md-6" id="pengeluaranField_{{ $item->id }}" style="display: none;">
                            <div class="mb-3 custom-form-group">
                                <label for="pengeluaran" class="form-label">Jumlah Pengeluaran</label>
                                <input type="text" class="form-control" id="pengeluaran_{{ $item->id }}" name="pengeluaran"
                                    value="{{ number_format($item->jumlah, 0, ',', ',') }}" required 
                                    onkeyup="formatNumberWithComma(this)">
                            </div>
                        </div>
                        <!-- Bukti Pembayaran -->
                        <!-- Status Pembayaran -->
                        <div class="col-md-6">
                            <div class="mb-3 custom-form-group">
                                <label for="status_pembayaran_{{ $item->id }}" class="form-label">Status Pembayaran</label>
                                <select class="form-select" name="status_pembayaran" id="status_pembayaran_{{ $item->id }}"
                                    required onchange="toggleTanggalPembayaranFields({{ $item->id }})">
                                    <option value="lunas">Lunas</option>
                                    <option value="belum_lunas">Belum Lunas</option>
                                    <option value="cicil">Cicil</option>
                                </select>
                            </div>
                        </div>
                        <!-- Tanggal Pembayaran Awal and Tanggal Pembayaran Akhir Container (with unique ID) -->
                        <div class="col-md-6" id="tanggal_pembayaran_fields_{{ $item->id }}" style="display: none;">
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
                        <!-- Keterangan -->
                        <div class="col-12">
                            <div class="mb-3 custom-form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    value="{{ $item->keterangan }}" >
                            </div>
                        </div>
                        <!-- Button to submit the form -->
                        <div class="col-12">
                            <div class="mb-3 custom-form-group">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to toggle fields based on the selected "jenis"
    document.addEventListener("DOMContentLoaded", function () {
        var tipePembayaranSelect = document.getElementById("tipe_pembayaran_{{ $item->id }}");
        var statusPembayaranSelect = document.getElementById("status_pembayaran_{{ $item->id }}");
        var buktiPembayaranField = document.getElementById("bukti_pembayaran_field_{{ $item->id }}");
        var tanggalPembayaranFields = document.getElementById("tanggal_pembayaran_fields_{{ $item->id }}");
        var jenisSelect = document.getElementById("jenis_{{ $item->id }}");
        var pemasukanField = document.getElementById("pemasukanField_{{ $item->id }}");
        var pengeluaranField = document.getElementById("pengeluaranField_{{ $item->id }}");

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

            if (jenisSelect.value === "pemasukan") {
                pemasukanField.style.display = "block";
                pengeluaranField.style.display = "none";
            } else if (jenisSelect.value === "pengeluaran") {
                pemasukanField.style.display = "none";
                pengeluaranField.style.display = "block";
            } else {
                pemasukanField.style.display = "none";
                pengeluaranField.style.display = "none";
            }
        }

        tipePembayaranSelect.addEventListener("change", updateVisibility);
        statusPembayaranSelect.addEventListener("change", updateVisibility);
        jenisSelect.addEventListener("change", updateVisibility);
        // Trigger the change event to initialize the form based on the default selected values
        tipePembayaranSelect.dispatchEvent(new Event("change"));
        statusPembayaranSelect.dispatchEvent(new Event("change"));
        jenisSelect.dispatchEvent(new Event("change"));
    });

    function formatNumberWithComma(inputField) {
        let input = inputField.value;
        // Remove any non-digit characters, including commas
        let number = input.replace(/[^0-9]/g, '');
        // Format the number with commas and update the input field
        inputField.value = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
