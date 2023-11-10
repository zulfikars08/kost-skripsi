<!-- Tombol untuk membuka modal tambah data -->
<!-- Modal untuk tambah data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Laporan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('laporan-keuangan.store') }}" method="post">
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
                        <label for="jenis" class="form-label">Jenis</label>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="" selected disabled>Pilih Jenis</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group" style="display: none;" id="pemasukanField">
                        <label for="pemasukan" class="form-label">Jumlah Pemasukan</label>
                        <input type="number" class="form-control" id="pemasukan" name="pemasukan">
                    </div>
                    <div class="mb-3 custom-form-group" style="display: none;" id="pengeluaranField">
                        <label for="pengeluaran" class="form-label">Jumlah Pengeluaran</label>
                        <input type="number" class="form-control" id="pengeluaran" name="pengeluaran">
                    </div>
                    
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                    {{-- <div class="mb-3 custom-form-group">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil elemen select "jenis" dan input fields
        const jenisSelect = document.getElementById("jenis");
        const pemasukanField = document.getElementById("pemasukanField");
        const pengeluaranField = document.getElementById("pengeluaranField");

        // Tambahkan event listener ketika pemilihan "jenis" berubah
        jenisSelect.addEventListener("change", function () {
            const selectedJenis = jenisSelect.value;

            // Sembunyikan semua input fields terlebih dahulu
            pemasukanField.style.display = "none";
            pengeluaranField.style.display = "none";

            // Tampilkan input field yang sesuai dengan jenis yang dipilih
            if (selectedJenis === "pemasukan") {
                pemasukanField.style.display = "block";
            } else if (selectedJenis === "pengeluaran") {
                pengeluaranField.style.display = "block";
            }
        });
    });
</script>
