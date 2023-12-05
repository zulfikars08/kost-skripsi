<div class="table-responsive" >
    <table class="table table-striped" style="width: 100%;" >
        <thead>
            <tr>
                <th style="white-space: nowrap;">No</th>
                <th style="white-space: nowrap;">No Kamar</th>
                <th style="white-space: nowrap;">Nama</th>
                <th style="white-space: nowrap;">Lokasi Kos</th>
                    <!-- Filter by Lokasi Kos dropdown here -->
                    {{-- <div class="dropdown">
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="lokasiDropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lokasi Kos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="lokasiDropdown">
                            <form action="{{ route('transaksi.index') }}" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="filter_by_lokasi" id="lokasiKos">
                                        <option value="">Semua Lokasi Kos</option>
                                        @foreach ($lokasiKosData as $lokasiKosOption)
                                        <option value="{{ $lokasiKosOption->nama_kos }}">{{
                                            $lokasiKosOption->nama_kos }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer px-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </th>
                <th style="white-space: nowrap;">Tanggal</th>
                <th style="white-space: nowrap;">Jumlah Tarif</th>
                <th style="white-space: nowrap;">Tipe Pembayaran</th>
                <th style="white-space: nowrap;">Bukti Pembayaran</th>
                <th style="white-space: nowrap;">Status Pembayaran</th>
                    
                    {{-- <div class="dropdown">
                        <a class="filter-icon dropdown-toggle" href="#" role="button" id="statusDropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Status
                        </a>
                        <div class="dropdown-menu" aria-labelledby="statusDropdown">
                            <form action="{{ route('transaksi.index') }}" method="get">
                                <div class="form-group px-2">
                                    <select class="form-control" name="filter_by_status_pembayaran" id="filterByStatus">
                                        <option value="">Semua Status Pembayaran</option>
                                        <option value="Lunas" {{ request('filter_by_status_pembayaran')==='Lunas'
                                            ? 'selected' : '' }}>Lunas</option>
                                        <option value="Cicil" {{ request('filter_by_status_pembayaran')==='Cicil'
                                            ? 'selected' : '' }}>Cicil</option>
                                        <option value="belum_lunas" {{ request('filter_by_status_pembayaran')==='Belum Lunas'
                                            ? 'selected' : '' }}>Belum Lunas</option>
                                    </select>
                                </div>
                                <div class="modal-footer px-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </th>

                <th style="white-space: nowrap;">Tanggal Awal</th>
                <th style="white-space: nowrap;">Tanggal Akhir</th>
                {{-- <th style="white-space: nowrap;">Kebersihan</th>
                <th style="white-space: nowrap;">Total</th> --}}
                <th style="white-space: nowrap;">Keterangan</th>
                {{-- <th style="white-space: nowrap;">Pengeluaran</th> --}}
                <th style="white-space: nowrap;">Aksi</th>
            </tr>
            <tr>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksiData as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <!-- No Kamar -->
                <td>
                    @if ($item->kamar)
                        {{ $item->kamar->no_kamar }}
                    @endif
                </td>
                <!-- Nama -->
                <td>
                    @if ($item->penyewa)
                        {{ $item->penyewa->nama }}
                    @else
                        No Penyewa Found
                    @endif
                </td>
                <!-- Nama Kos -->
                <td>
                    @if ($item->lokasiKos)
                        {{ $item->lokasiKos->nama_kos }}
                    @endif
                </td>
                <!-- Tanggal -->
                <td>
                    {{ $item->tanggal ?? '-' }}
                </td>
                <!-- Jumlah Tarif -->
                <td>Rp {{ number_format($item->jumlah_tarif, 0, ',', '.') }}</td>
                <!-- Tipe Pembayaran -->
                <td>{{ $item->tipe_pembayaran ? $item->tipe_pembayaran : '-' }}</td>
                <td>
                    @if ($item->tipe_pembayaran === 'non-tunai' && $item->bukti_pembayaran)
                    <button type="button" class="btn btn-link btn-sm"
                    onclick="openImageModal('{{ asset('storage/' . $item->bukti_pembayaran) }}')">
                    <i class="fas fa-eye"></i>
                </button>
                    @elseif ($item->tipe_pembayaran === 'tunai')
                        Cash Payment
                    @else
                        No Bukti Pembayaran
                    @endif
                </td>
                
                <td>
                    @if ($item->status_pembayaran === 'lunas')
                        <b><span style="color: green;"> Lunas </span></b>
                    @elseif ($item->status_pembayaran === 'cicil')
                        <b><span style="color: rgb(255, 123, 0);"> Cicil </span></b>
                    @elseif ($item->status_pembayaran === 'belum_lunas')
                        <b><span style="color: red;"> Belum Lunas </span></b>
                    @else
                        {{ $item->status_pembayaran }}
                    @endif
                </td>
                <td>{{ $item->tanggal_pembayaran_awal ? $item->tanggal_pembayaran_awal : '-' }}</td>
                <td>{{ $item->tanggal_pembayaran_akhir ? $item->tanggal_pembayaran_akhir : '-' }}</td>

                <!-- Kebersihan -->
                {{-- <td>{{ $item->kebersihan }}</td> --}}
                <!-- Total -->
                {{-- <td>{{ ($item->jumlah_tarif === 0 && $item->kebersihan === 0) ? 0 : ($item->jumlah_tarif - $item->kebersihan) }}</td> --}}
                <!-- Keterangan -->
                <td>{{ $item->keterangan }}</td>
                <!-- Pengeluaran -->
                {{-- <td>{{ $item->pengeluaran }}</td> --}}
                <td>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="fas fa-edit" style="color: white"></i>
                        </button>
                
                        @include('transaksi.edit')

                        <form onsubmit="return confirm('Yakin akan menghapus data?')" class="d-inline" action="{{ route('transaksi.destroy', $item->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="submit" class="btn btn-danger btn-sm"style="margin-left: 5px"><i class="fas fa-trash" ></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="16">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $transaksiData->appends(request()->except('page'))->links() }}
</div>
<!-- transaksi.filter.blade.php -->
