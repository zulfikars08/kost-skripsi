<!-- resources/views/tanggal-transaksi/create-modal.blade.php -->

<div class="modal fade" id="createTanggalTransaksiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tanggal Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create form for adding new Tanggal Transaksi -->
                <form method="POST" action="{{ route('tanggal-transaksi.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <input type="month" class="form-control" id="bulan" name="bulan" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
