function formatAndSetDecimalValue(input, hiddenInputId) {
    // Dapatkan nilai dari input harga
    let hargaValue = input.value;

    // Menghapus karakter selain digit dan titik desimal
    let numericValue = hargaValue.replace(/[^\d.]/g, '');

    // Pisahkan nilai menjadi bagian utuh dan desimal
    let parts = numericValue.split('.');
    let integerPart = parts[0];
    let decimalPart = parts[1];

    // Ubah bagian desimal menjadi bentuk yang benar
    if (decimalPart) {
        decimalPart = '.' + decimalPart;
    }

    // Gabungkan kembali bagian utuh dan desimal
    let combinedValue = integerPart + (decimalPart || '');

    // Ambil nilai yang dapat disimpan (tanpa separator ribuan)
    let hargaDecimal = parseFloat(combinedValue);

    // Jika hargaDecimal adalah NaN (Not a Number), atur nilai menjadi null
    if (isNaN(hargaDecimal)) {
        hargaDecimal = null;
    }

    // Tentukan apakah harus menyimpan sebagai integer atau desimal
    let savedValue = hargaDecimal;
    if (decimalPart && parseFloat(decimalPart) === 0) {
        savedValue = Math.round(hargaDecimal);
    }

    // Setel nilai input tersembunyi dengan nilai yang sesuai
    document.getElementById(hiddenInputId).value = savedValue;

    // Format nilai dengan menambahkan separator ribuan
    let formattedValue = combinedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    // Setel nilai input dengan nilai yang sudah diformat
    input.value = formattedValue;
}
