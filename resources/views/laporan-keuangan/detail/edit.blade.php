<div class="modal fade" id="editDataModal{{ $item->id }}" tabindex="-1" aria-labelledby="editDataModal{{ $item->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $item->id }}Label">Edit Data Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Your edit form goes here -->
                <form action="{{ route('laporan-keuangan.update', $item->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $item->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kos" class="form-label">Nama Kos</label>
                        <input type="text" class="form-control" id="nama_kos" name="nama_kos" value="{{ $item->lokasi->nama_kos }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="pemasukan" {{ $item->jenis === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ $item->jenis === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pemasukan" class="form-label">Jumlah Pemasukan</label>
                        <input type="number" class="form-control" id="pemasukan" name="pemasukan" value="{{ $item->jenis === 'pemasukan' ? $item->pemasukan : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="pengeluaran" class="form-label">Jumlah Pengeluaran</label>
                        <input type="number" class="form-control" id="pengeluaran" name="pengeluaran" value="{{ $item->jenis === 'pengeluaran' ? $item->pengeluaran : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="pendapatan_bersih" class="form-label">Pendapatan Bersih</label>
                        <input type="number" class="form-control" id="pendapatan_bersih" name="pendapatan_bersih" value="{{ $item->pendapatan_bersih }}">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $item->keterangan }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
