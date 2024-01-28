{{-- resources/views/penyewa/index.blade.php --}}
@extends('layout.template')

@section('content')
@include('komponen.pesan')

<div class="container-fluid">
    <h3 class="text-start mb-4">Data Penyewa</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" id="search-form">
                <div class="input-group">
                    <input class="form-control me-2" type="search" name="katakunci" placeholder="Masukkan Nama"
                        aria-label="Search" id="search-input">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                </div>
            </form>
            <!-- Tambah Data Button -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            <!-- Include the modal partial -->
            @include('penyewa.create')
        </div>
        <!-- PENYEWA LIST TABLE -->
        <div id="search-results">
            {{-- Content will be loaded via AJAX --}}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load initial data
        fetchPenyewaData();

        // Fetch data as the user types in the search field
        $('#search-input').on('input', function() {
            fetchPenyewaData($(this).val());
        });

        // Bind AJAX load to pagination links
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetchPenyewaData($('#search-input').val(), page);
        });

        // AJAX function to fetch data
        function fetchPenyewaData(katakunci = '', page = 1) {
            $.ajax({
                url: "{{ route('penyewa.index') }}",
                type: 'GET',
                data: { katakunci: katakunci, page: page },
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
