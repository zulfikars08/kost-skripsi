{{-- <!-- Tombol untuk membuka modal tambah data -->
<!-- Modal untuk tambah data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Laporan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('laporan-keuangan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Left Column -->
                            <div class="mb-3 custom-form-group">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="mb-3 custom-form-group">
                                <label for="lokasi_id" class="form-label">Nama Kos</label>
                                <select class="form-select" id="lokasi_id" name="lokasi_id" required>
                                    <option value="" selected disabled>Pilih Nama Kos</option>
                                    @foreach($lokasiKos as $lokasi)
                                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama_kos }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 custom-form-group" id="kamarSelectContainer">
                                <label for="kamar_id" class="form-label">Nomor Kamar</label>
                                <select class="form-select" id="kamar_id" name="kamar_id" required>
                                    <option value="" selected disabled>Pilih Nomor Kamar</option>
                                    @foreach($kamars as $kamar)
                                    <option value="{{ $kamar->id }}" data-lokasi="{{ $kamar->lokasi_id }}">{{ $kamar->no_kamar }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 custom-form-group">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="" selected disabled>Pilih Jenis</option>
                                    <option value="pemasukan">Pemasukan</option>
                                    <option value="pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Right Column -->
                            <div class="mb-3 custom-form-group">
                                <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                                <select class="form-select" name="tipe_pembayaran" id="tipe_pembayaran">
                                    <option value="tunai">Tunai</option>
                                    <option value="non-tunai">Non-Tunai</option>
                                </select>
                            </div>
                            <div class="mb-3 custom-form-group" style="display: none;" id="pemasukanField">
                                <label for="pemasukan" class="form-label">Jumlah Pemasukan</label>
                                <input type="number" class="form-control" id="pemasukan" name="pemasukan">
                            </div>
                            <div class="mb-3 custom-form-group" style="display: none;" id="pengeluaranField">
                                <label for="pengeluaran" class="form-label">Jumlah Pengeluaran</label>
                                <input type="number" class="form-control" id="pengeluaran" name="pengeluaran">
                            </div>
                            <div class="mb-3 custom-form-group" id="bukti_pembayaran_field" style="display: none;">
                                <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran">
                            </div>
                            <div class="mb-3 custom-form-group">
                                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                <select class="form-select" name="status_pembayaran" id="status_pembayaran">
                                    <option value="lunas">Lunas</option>
                                    <option value="cicil">Cicil</option>
                                    <option value="belum-lunas">Belum Lunas</option>
                                </select>
                            </div>
                            <div class="mb-3 custom-form-group" id="tanggal_pembayaran_fields" style="display: none;">
                                <label for="tanggal_pembayaran_awal" class="form-label">Tanggal Awal Cicil</label>
                                <input type="date" class="form-control" name="tanggal_pembayaran_awal" id="tanggal_pembayaran_awal">
                                <label for="tanggal_pembayaran_akhir" class="form-label">Tanggal Akhir Cicil</label>
                                <input type="date" class="form-control" name="tanggal_pembayaran_akhir" id="tanggal_pembayaran_akhir">
                            </div>
                            <div class="mb-3 custom-form-group">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const kamarOptions = @json($kamars->keyBy('id')->map->only('lokasi_id', 'no_kamar'));
</script> --}}
