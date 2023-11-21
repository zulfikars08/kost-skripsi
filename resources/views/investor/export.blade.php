<div class="modal fade" id="generateReportModals" tabindex="-1" role="dialog" aria-labelledby="generateReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateReportModalLabel">Generate Financial Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('generate-investor-report') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kos">Name of Kos:</label>
                        <select name="nama_kos" id="nama_kos" class="form-control">
                            <option value="">Select Kos</option>
                            @foreach ($lokasiKos as $kos)
                                <option value="{{ $kos->id }}">{{ $kos->nama_kos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Month:</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Select Month</option>
                            @foreach ($months as $key => $month)
                                <option value="{{ $key }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Year:</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Select Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Unduh Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>