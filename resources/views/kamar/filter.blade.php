
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('kamar.index') }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 custom-form-group">
                        <label for="filterNamaKos">Lokasi Kos</label>
                        <select class="form-control" id="filterNamaKos" name="nama_kos">
                            <option value="">Pilih Lokasi Kos</option>
                            @foreach ($lokasiKosOptions as $lokasiKosOption)
                            <option value="{{ $lokasiKosOption->nama_kos }}">{{ $lokasiKosOption->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                        <select class="form-control" name="tipe_kamar" id="tipe_kamar" required>
                            <option value="">Pilih Tipe Kamar</option>
                            <option value="AC" @if(old('tipe_kamar')==='AC' ) selected @endif>AC</option>
                            <option value="Non AC" @if(old('tipe_kamar')==='Non AC' ) selected @endif>Non AC</option>
                        </select>
                    </div>
                    <div class="mb-3 custom-form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">Pilih Status Kamar</option>
                            <option value="Belum Terisi" @if(old('status')==='Belum Terisi' ) selected @endif>
                                Belum Terisi</option>
                            <option value="Sudah Terisi" @if(old('status')==='Sudah Terisi' ) selected @endif>
                                Sudah Terisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between mb-3">
                        <button type="submit" class="btn btn-primary" id="filter-button">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
     const form = document.getElementById('filter-form');
 
     form.addEventListener('submit', function (event) {
         event.preventDefault(); // Prevent the form from submitting
 
         const namaKos = document.getElementById('filterNamaKos').value;
         const tipe_kamar = document.getElementById('tipe_kamar').value;
         const status = document.getElementById('status').value;
 
         const queryParams = [];
 
         if (namaKos) {
             queryParams.push(`nama_kos=${namaKos}`);
         }
         if (tipe_kamar) {
             queryParams.push(`tipe_kamar=${tipe_kamar}`);
         }
         if (status) {
             queryParams.push(`status=${status}`);
         }
 
         const url = "{{ route('kamar.index') }}";
         window.location.href = url + (queryParams.length > 0 ? '?' + queryParams.join('&') : '');
     });
 });
 </script>