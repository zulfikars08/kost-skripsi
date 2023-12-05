@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Manage User</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" id="search-form">
                <div class="input-group">
                    {{-- <button class="btn btn-secondary">Cari</button> --}}
                    <input class="form-control me-2" type="search" name="katakunci" placeholder="Masukan Nama"
                        aria-label="Search" id="search-input">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                </div>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('manage-users.create')
        </div>
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
            var katakunci = $(this).val();
            fetchPenyewaData(katakunci);
        });

        // Prevent form submission and fetch data when search button is clicked
        $('#search-button').click(function() {
            var katakunci = $('#search-input').val();
            fetchPenyewaData(katakunci);
        });

        // AJAX function to fetch data
        function fetchPenyewaData(katakunci = '') {
            $.ajax({
                url: "{{ route('manage-users.index') }}",
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
