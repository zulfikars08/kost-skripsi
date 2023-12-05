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
        Data Investor
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
                <button type="button" class="btn btn-success" style="margin-left: 3px" data-bs-toggle="modal"
                    data-bs-target="#generateReportModals">
                    Excel
                </button>
                @include('investor.export')
            </div>
            <!-- Include the modal partial -->
        </div>

        <!-- INVESTOR LIST TABLE -->
        <!-- INVESTOR LIST TABLE -->
        <div id="investor-table-body">
            <!-- Data will be dynamically loaded here -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Define the fetchData function
        function fetchData(query = '') {
            $.ajax({
                url: "{{ route('investor.detail.index') }}",
                type: "GET",
                data: {'nama': query},
                success: function(data) {
                    $('#investor-table-body').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        fetchData();
        $('#search-input').on('keyup', function() {
            var query = $(this).val();
            fetchData(query);
        });
    });
</script>
@endsection