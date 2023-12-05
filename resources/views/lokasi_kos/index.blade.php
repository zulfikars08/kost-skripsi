@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Lokasi Kos</h3>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" id="search-form">
                <div class="input-group">
                    <input class="form-control me-2" type="search" name="katakunci" placeholder="Masukkan Nama Lokasi"
                        aria-label="Search" id="search-input">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </form>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('lokasi_kos.create')
            <!-- Include the modal partial -->
        </div>
        <div id="search-results">

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load initial data
        fetchLokasiData();

        // Fetch data as the user types in the search field
        $('#search-input').on('input', function() {
            var katakunci = $(this).val();
            fetchLokasiData(katakunci);
        });

        // Prevent form submission and fetch data when search button is clicked
        $('#search-button').click(function() {
            var katakunci = $('#search-input').val();
            fetchLokasiData(katakunci);
        });

        // AJAX function to fetch data
        function fetchLokasiData(katakunci = '') {
            $.ajax({
                url: "{{ route('lokasi_kos.index') }}",
                type: 'GET',
                data: { katakunci: katakunci },
                success: function(response) {
                    $('#search-results').html(response);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>

@endsection