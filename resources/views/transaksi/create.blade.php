<!-- transaksi.add-transaction.blade.php -->
<div class="modal fade" id="addTransactionModal{{ $roomId }}-{{ $lokasiId }}" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kamar_id" value="{{ $roomId }}">
                    <input type="hidden" name="lokasi_id" value="{{ $lokasiId }}">
                    
                    <!-- Add your form fields here -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_tarif" class="form-label">Jumlah Tarif</label>
                        <input type="text" class="form-control" name="jumlah_tarif" id="jumlah_tarif">
                    </div>
                    <div class="mb-3">
                        <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                        <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran">
                            <option value="tunai">Tunai</option>
                            <option value="non-tunai">Non-Tunai</option>
                        </select>
                    </div>
                    <!-- Other form fields go here -->

                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
