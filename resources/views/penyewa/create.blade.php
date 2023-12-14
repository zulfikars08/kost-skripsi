<div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Penyewa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  id="myForm" action="{{ route('penyewa.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Nama Kos (Kost name) Dropdown -->
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
                        <div class="mb-3 custom-form-group">
                            <label for="kamar_id" class="form-label">Nomor Kamar</label>
                            <select class="form-select" id="kamar_id" name="kamar_id" required>
                                <option value="" selected disabled>Pilih Nomor Kamar</option>
                                @foreach($kamars as $kamar)
                                <option value="{{ $kamar->id }}" data-lokasi="{{ $kamar->lokasi_id }}">{{ $kamar->no_kamar
                                    }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Nama -->
                    <div class="mb-3 custom-form-group">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status_penyewa">Edit Status Penyewa:</label>
                        <select name="status_penyewa" id="status_penyewa">
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <!-- Keterangan Pembayaran -->
                    {{-- <div class="mb-3 custom-form-group">
                        <label for="keterangan" class="form-label">Keterangan Pembayaran</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" required>
                    </div> --}}

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