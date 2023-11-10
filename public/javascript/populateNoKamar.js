// script.js
document.addEventListener("DOMContentLoaded", function () {
    const namaKosSelect = document.getElementById("nama_kos");
    const noKamarInput = document.getElementById("no_kamar");

    // Event listener for changes in the Nama Kos select
    namaKosSelect.addEventListener("change", () => {
        const selectedLocationId = namaKosSelect.value;

        // Clear the "No. Kamar" input
        noKamarInput.value = "";

        if (selectedLocationId in roomsByLocation) {
            const availableRooms = roomsByLocation[selectedLocationId];
            if (availableRooms.length > 0) {
                // Set the "No. Kamar" input to the first available room number
                noKamarInput.value = availableRooms[0].no_kamar;
            } else {
                // Handle the case when there are no available rooms
                noKamarInput.value = "Semua Kamar Terisi";
            }
        } else {
            // Handle the case when the selected location has no room data
            noKamarInput.value = "Tidak Ada Data Kamar";
        }
    });
});
