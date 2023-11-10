<!-- resources/views/penghuni/edit.blade.php -->

<!-- Modal -->
<div class="modal fade" id="editPenghuniModal{{ $item->id }}" tabindex="-1" aria-labelledby="editPenghuniModal{{ $item->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPenghuniModal{{ $item->id }}Label">Edit Penghuni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for editing Penghuni -->
                <form action="{{ route('penghuni.update',  $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Select Penyewa -->
                        <div class="mb-3 custom-form-group">
                            <label for="penyewa_id" class="form-label text-start">Penyewa ID</label>
                            <input type="text" class="form-control" id="penyewa_id" value="{{ request()->route('id') }}" disabled>
                        </div>
                        <!-- Nama -->
                        <div class="mb-3 custom-form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $item->nama }}" required>
                        </div>
                        <!-- Tanggal Lahir -->
                        <div class="mb-3 custom-form-group">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $item->tanggal_lahir }}">
                        </div>
                        <!-- Jenis Kelamin -->
                        <div class="mb-3 custom-form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin">
                                <option value="Laki-Laki" {{ $item->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="Perempuan" {{ $item->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <!-- No Telepon -->
                        <div class="mb-3 custom-form-group">
                            <label for="no_hp" class="form-label">No Telepon</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{ $item->no_hp }}" required>
                        </div>
                        <!-- Pekerjaan -->
                        <div class="mb-3 custom-form-group">
                            <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{ $item->pekerjaan }}">
                        </div>
                        <!-- Perusahaan -->
                        <div class="mb-3 custom-form-group">
                            <label for="perusahaan" class="form-label">Perusahaan</label>
                            <input type="text" class="form-control" name="perusahaan" id="perusahaan" value="{{ $item->perusahaan }}">
                        </div>
                        <!-- Martial Status -->
                        <div class="mb-3 custom-form-group">
                            <label for="martial_status">Martial Status</label>
                            <select name="martial_status" id="martial_status">
                                <option value="Belum Kawin" {{ $item->martial_status == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ $item->martial_status == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ $item->martial_status == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ $item->martial_status == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Penghuni</button>
                </form>
            </div>
        </div>
    </div>
</div>
c