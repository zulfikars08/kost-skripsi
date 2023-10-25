function checkFormAndSubmit() {
    // Check for validation errors
    if (hasValidationErrors()) {
        // Display an error toast
        showErrorToast();
    } else {
        // Submit the form
        document.getElementById('myForm').submit();
    }
}

function hasValidationErrors() {

    const noKamarField = document.getElementById('no_kamar');
    if (!noKamarField.value.trim()) {
        return true;
    }


    return false; 
}

function showErrorToast() {
    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
    errorToast.show();
}

function showSuccessToast() {
    var successToast = new bootstrap.Toast(document.getElementById('successToast'));
    successToast.show();
}

function toggleBuktiPembayaranField() {
const tipePembayaran = document.getElementById('tipe_pembayaran').value;
const buktiPembayaranField = document.getElementById('bukti_pembayaran_field');

if (tipePembayaran === 'non-tunai') {
    buktiPembayaranField.style.display = 'block'; // Show the field for Non-Tunai
} else {
    buktiPembayaranField.style.display = 'none'; // Hide the field for Tunai
}
}

function toggleTanggalPembayaranFields() {
const statusPembayaran = document.getElementById('status_pembayaran').value;
const tanggalPembayaranFields = document.getElementById('tanggal_pembayaran_fields');

if (statusPembayaran === 'cicil') {
    tanggalPembayaranFields.style.display = 'block'; // Show the date fields for Cicil
} else {
    tanggalPembayaranFields.style.display = 'none'; // Hide the date fields for Lunas dan Belum Lunas
}
}