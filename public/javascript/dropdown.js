document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen select "Nama Kos" dan "Nomor Kamar"
    const lokasiSelect = document.getElementById("lokasi_id");
    const kamarSelect = document.getElementById("kamar_id");
    const kamarSelectContainer = document.getElementById("kamarSelectContainer");

    // Simpan semua opsi nomor kamar ke dalam sebuah objek JavaScript
    // const kamarOptions = {!! json_encode($kamars->keyBy('id')->map->only('lokasi_id', 'no_kamar')) !!};

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

    // Add event listener to tipe_pembayaran
    const tipePembayaranSelect = document.getElementById('tipe_pembayaran');
    tipePembayaranSelect.addEventListener('change', toggleBuktiPembayaranField);

    // Call the function to handle the initial state
    toggleBuktiPembayaranField();
    toggleTanggalPembayaranFields()
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
});
