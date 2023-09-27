 // Ambil elemen input harga
 var inputHarga = document.getElementById('harga');

 // Tambahkan event listener untuk setiap perubahan nilai
 inputHarga.addEventListener('input', function () {
     var nilaiInput = this.value;

     // Hapus semua karakter selain angka
     var nilaiBersih = nilaiInput.replace(/\D/g, '');

     // Setel nilai yang telah dibersihkan ke input
     this.value = nilaiBersih;
 });