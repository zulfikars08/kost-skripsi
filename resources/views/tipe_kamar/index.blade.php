@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Data Tipe Kamar
    </h3>

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
            <div  class="d-flex justify-content-between mb-3">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                @include('tipe_kamar.create') <!-- Include the modal partial for creating new data -->
            </div>
        </div>
    </div>
    <div id="search-results">
        @include('tipe_kamar.list')
    </div>
</div>
<script>
    $(document).ready(function() {
     function fetchLokasiData() {
         var formData = $('#search-form').serialize() + '&' + $('#filter-form').serialize();
         console.log('Fetching data with:', formData); // Debugging line
         $.ajax({
             url: "{{ route('tipe_kamar.index') }}",
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
         fetchLokasiData();
     });
 
     $('#search-input').on('input', fetchLokasiData);
 });
 
 </script>
@endsection
