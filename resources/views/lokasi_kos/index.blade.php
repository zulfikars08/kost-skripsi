@extends('layout.template')

@section('content')
@include('komponen.pesan')
<div class="container-fluid">
    <h3 class="text-start" style="margin: 20px 0; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Data Lokasi Kos</h3>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <!-- SEARCH FORM -->
            <form class="d-flex" action="{{ route('lokasi_kos.index') }}" method="get" id="search-form">
                <div class="input-group">
                    {{-- <label class="input-group-text search-input" for="search-input">Search</label> --}}
                    <input class="form-control" type="search" name="katakunci" placeholder="Masukkan kata kunci"
                        aria-label="Search" id="search-input">
                    <button class="btn btn-secondary" type="submit">Cari</button>
                </div>
            </form>


            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
            @include('lokasi_kos.create')
            <!-- Include the modal partial -->



        </div>
    </div>

    <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Lokasi Kos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('lokasi_kos.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <!-- Nama Kos -->
                        <div class="mb-3 custom-form-group">
                            <label for="nama_kos" class="form-label">Nama Kos</label>
                            <input type="text" class="form-control" name="nama_kos" id="nama_kos" value="{{ old('nama_kos') }}" required>
                            @error('nama_kos')
                                <div class="text-danger">Nama Kos sudah digunakan</div>
                            @enderror
                        </div>
                        <!-- Jumlah Kamar -->
                        <div class="mb-3 custom-form-group">
                            <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                            <input type="text" class="form-control" name="jumlah_kamar" id="jumlah_kamar" value="{{ old('jumlah_kamar') }}" required>
                        </div>
                        
                        <!-- Alamat -->
                        <div class="mb-3 custom-form-group">
                            <label for="alamat_kos" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat_kos" id="alamat_kos" value="{{ old('alamat_kos') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- LOKASI_KOS LIST TABLE -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kos</th>
                <th>Jumlah Kamar</th>
                <th>Alamat</th>
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
                <td>{{ $item->nama_kos }}</td>
                <td>{{ $item->jumlah_kamar }}</td>
                <td>{{ $item->alamat_kos }}</td>
                <td>
                    <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline"
                        action="{{ route('lokasi_kos.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    <a href="{{ route('lokasi_kos.detail', $item->id) }}" class="btn btn-primary btn-sm"> 
                        <i class="fas fa-info-circle" style="color: white"></i></a>
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