@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <button type="button"
        style="display: flex; align-items: center; background-color: rgb(64, 174, 207); color: #fff; border: none; padding: 5px; border-radius: 5px;"
        onclick="window.location.href='{{ route('investor.index') }}'">
        <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
    </button>
    <h3 class="text-start"
        style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
        Detail Data Laporan Investor
    </h3>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" method="get" id="search-form">
                <div class="input-group">
                    <input class="form-control me-2" type="search" id="search-input" placeholder="Masukkan nama"
                        aria-label="Search">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                        </div>
                </div>
            </form>
            <div class="d-flex justify-content-between mb-3">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#tambahDataModal">
                    <i class="fas fa-plus"></i> Tambah Data Investor
                </button>
                @include('investor.detail.create')
               
            </div>
            <!-- Include the modal partial -->
        </div>

        <!-- INVESTOR LIST TABLE -->
        <!-- INVESTOR LIST TABLE -->
        <div id="investor-table-body">
            <!-- Data will be dynamically loaded here -->
            @include('investor.detail.list')
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Define variables to store filter values
        var initialQuery = '';
        var initialLokasiId = '';
        var initialBulan = '';
        var initialTahun = '';

        // Function to fetch data based on URL parameters
        function fetchDataFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            var query = urlParams.get('nama') || '';
            var lokasi_id = urlParams.get('lokasi_id') || '';
            var bulan = urlParams.get('bulan') || '';
            var tahun = urlParams.get('tahun') || '';

            $('#search-input').val(query);
            $('#lokasi_id').val(lokasi_id);
            $('#bulan').val(bulan);
            $('#tahun').val(tahun);

            fetchData(query, lokasi_id, bulan, tahun);
        }

        // Define the fetchData function
        function fetchData(query = '', lokasi_id = '', bulan = '', tahun = '') {
            $.ajax({
                url: "{{ route('investor.detail.index') }}",
                type: "GET",
                data: {
                    'nama': query,
                    'lokasi_id': lokasi_id,
                    'bulan': bulan,
                    'tahun': tahun
                },
                success: function(data) {
                    $('#investor-table-body').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        // Initial fetchData call with URL parameters
        fetchDataFromUrl();

        // Search input
        $('#search-input').on('keyup', function() {
            var query = $(this).val();
            var lokasi_id = $('#lokasi_id').val();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            fetchData(query, lokasi_id, bulan, tahun);
        });

        // Reset button
        $('#reset-button').on('click', function() {
            resetSearch();
        });

        // Function to reset the search
        function resetSearch() {
            $('#search-input').val(initialQuery);
            $('#lokasi_id').val(initialLokasiId);
            $('#bulan').val(initialBulan);
            $('#tahun').val(initialTahun);
            fetchData(initialQuery, initialLokasiId, initialBulan, initialTahun);
        }
    });
</script>




@endsection