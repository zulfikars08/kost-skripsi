@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Transaksi Penyewa</h3>
    <!-- TRANSAKSI LIST TABLE -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" id="search-form">
                <input class="form-control me-2" type="search" name="katakunci" placeholder="Masukkan Nama" aria-label="Search" id="search-input">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </form>

            <div class="d-flex justify-content-between mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Filter
                </button>
                @include('transaksi.filter') <!-- Include the filter modal -->
            
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generateReportModal" style="margin-left: 5px;">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </button>
                @include('transaksi.export')
            </div>
        </div>
        <div id="search-results">
            @include('transaksi.list')
        </div>
    </div>
</div>
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="buktiPembayaranImage" src="" alt="Bukti Pembayaran" class="img-fluid" style="max-width: 100%; max-height: 80vh;">
            </div>
        </div>
    </div>
</div>
<script>
    function openImageModal(imageUrl) {
        // Set the image source
        document.getElementById('buktiPembayaranImage').src = imageUrl;
        // Open the modal
        $('#imageModal').modal('show');
    }
</script>
<script>
   $(document).ready(function() {
    function fetchTransaksiData() {
        var formData = $('#search-form').serialize() + '&' + $('#filter-form').serialize();
        console.log('Fetching data with:', formData); // Debugging line
        $.ajax({
            url: "{{ route('transaksi.index') }}",
            type: 'GET',
            data: formData,
            success: function(response) {
                // console.log('Data fetched successfully'); // Debugging line
                $('#search-results').html(response);
            },
            error: function(error) {
                console.error('An error occurred:', error);
            }
        });
    }

    // Separate event handlers for search and filter
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        fetchTransaksiData();
    });

    $('#search-input').on('input', fetchTransaksiData);
});
</script>
@endsection
