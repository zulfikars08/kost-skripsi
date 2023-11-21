function formatAndSetIntegerValue(input) {
    // Menghilangkan karakter selain digit
    let formattedValue = input.value.replace(/\D/g, '');

    // Menambahkan separator ribuan
    formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    // Setel nilai input dengan nilai yang sudah diformat
    input.value = formattedValue;

    // Mengonversi nilai ke tipe data Integer
    let hargaInteger = parseInt(formattedValue.replace(/[.,]/g, ''), 10);

    // Jika hargaInteger adalah NaN (Not a Number), atur nilai menjadi 0
    if (isNaN(hargaInteger)) {
        hargaInteger = 0;
    }

    // Simpan nilai hargaInteger dalam hidden input atau kirim ke server
    document.getElementById('hargaInteger').value = hargaInteger;
}