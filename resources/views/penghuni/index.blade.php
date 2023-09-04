@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Penghuni</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('penghuni.index') }}" method="get" id="search-form">
                <div class="input-group">
                    <label class="input-group-text search-input" for="search-input">Search</label>
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>
            <script>
                $(document).ready(function() {
                    // Original data (you can replace this with your actual data)
                    var originalData = [
                        { name: "Item 1", value: "value1" },
                        { name: "Item 2", value: "value2" },
                        // ... more data ...
                    ];
                
                    // Populate the autocomplete suggestions
                    function populateAutocomplete(data) {
                        $("#search-input").autocomplete({
                            source: data.map(item => item.name),
                            select: function(event, ui) {
                                // Handle selection
                                // You can find the selected item value using ui.item.value
                            }
                        });
                    }
                
                    // Initialize autocomplete with original data
                    populateAutocomplete(originalData);
                
                    // Clear search input and revert to original data
                    $("#clear-button").click(function() {
                        $("#search-input").val("");
                        populateAutocomplete(originalData);
                    });
                });
            </script>



            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('penghuni.create')
            <!-- Include the modal partial -->



        </div>
    </div>
    

    <!-- LOKASI_KOS LIST TABLE -->
   <!-- LOKASI_KOS LIST TABLE -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>No HP</th>
            <th>Pekerjaan</th>
            <th>Perusahaan</th>
            <th>Tanggal Lahir</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i = $data->firstItem();
        @endphp
        @foreach ($data as $item)
        <tr>
            <td>{{ $i }}</td>
            <!-- Nama -->
            <td>{{ $item->nama }}</td>
            <!-- Jenis Kelamin -->
            <td>{{ $item->jenis_kelamin }}</td>
            <!-- No HP -->
            <td>{{ $item->no_hp }}</td>
            <!-- Pekerjaan -->
            <td>
                @if ($item->pekerjaan === 'Lainnya')
                    {{ $item->pekerjaan_lainnya }}
                @else
                    {{ $item->pekerjaan }}
                @endif
            </td>
            <!-- Perusahaan -->
            <td>{{ $item->perusahaan }}</td>
            <!-- Tanggal Lahir -->
            <td>{{ $item->tanggal_lahir }}</td>
            <!-- Status -->
            <td>{{ $item->status }}</td>
            <td>
                <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                    action="{{ route('lokasi_kos.destroy', $item->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
                <a href="{{ route('lokasi_kos.detail', $item->id) }}" class="btn btn-success btn-sm">Detail</a>
            </td>
        </tr>
        @php
        $i++;
        @endphp
        @endforeach
    </tbody>
</table>
{{ $data->withQueryString()->links() }}

</div>
</div>
</div>
</div>

@endsection