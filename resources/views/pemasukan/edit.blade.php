

<!-- Edit Data Pemasukan Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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
                    @method('PUT') <!-- Add this line for the update method -->
                    <div class="mb-3 custom-form-group">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $item->tanggal }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="lokasi_id" class="form-label">Nama Kos</label>
                        <select class="form-select" id="lokasi_id" name="lokasi_id" required>
                            <option value="{{ $item->lokasi_id }}" selected>{{ $item->lokasiKos->nama_kos }}</option>
                            @foreach($lokasiKos as $lokasi)
                                <option value="{{ $lokasi->id }}">{{ $lokasi->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tambahkan ID ke elemen div yang mengelilingi select "Nomor Kamar" -->
                    <div class="mb-3 custom-form-group" id="kamarSelectContainer">
                        <label for="kamar_id" class="form-label">Nomor Kamar</label>
                        <select class="form-select" id="kamar_id" name="kamar_id" required>
                            <option value="{{ $item->kamar_id }}" selected>{{ $item->kamar->no_kamar }}</option>
                            <!-- Populate the options with kamar data based on lokasi_id (similar to the creation modal) -->
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $item->jumlah }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required>{{ $item->keterangan }}</textarea>
                    </div>
                    <!-- Add other form fields as needed -->
                    <button type="submit" class="btn btn-primary">Update Data</button>
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