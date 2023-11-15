<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKeuanganExport;
use App\Models\Kamar;
use App\Models\Kategori;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\Penyewa;
use App\Models\TanggalLaporan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $namaKos = $request->input('nama_kos');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $statusPembayaran = $request->input('status_pembayaran');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
            // ... (your month data creation)
        }


        // Query the database based on the query parameters

        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        $lokasiKos = LokasiKos::all(); // Mengambil data lokasi kos
        $kamars = Kamar::all(); // Mengambil data nomor kamar
        $transaksis = Transaksi::all(); // Mengambil data transaksi
        $penyewas = Penyewa::all();
        $laporanKeuangan = LaporanKeuangan::all();
        $totalPemasukan = LaporanKeuangan::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = LaporanKeuangan::where('jenis', 'pengeluaran')->sum('jumlah'); // Mengatur URL untuk paginasi

        $query = LaporanKeuangan::query();

        // Apply filters
        if ($namaKos) {
            $query->where('lokasi_id', $namaKos);
        }

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        if ($statusPembayaran) {
            $query->where('status_pembayaran', $statusPembayaran);
        }


        // Get the filtered data
        $laporanKeuangan = $query->get();

      

    // Make sure $lokasiKos is defined before compacting it
    // $lokasiKos = LokasiKos::all();

        return view('laporan-keuangan.detail.index', compact('laporanKeuangan', 'lokasiKos', 'kamars', 'transaksis', 'penyewas', 'totalPemasukan', 'totalPengeluaran', 'months', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Di dalam metode create, Anda dapat melakukan beberapa hal, seperti mengambil data yang diperlukan
        // atau mereturn tampilan modal tambah data laporan keuangan.

        // Contoh pengambilan data yang mungkin Anda perlukan dalam modal tambah data:
        $lokasiKos = LokasiKos::all(); // Mengambil data lokasi kos
        $kamars = Kamar::all(); // Mengambil data nomor kamar
        $transaksis = Transaksi::all(); // Mengambil data transaksi
        $penyewas = Penyewa::all(); // Mengambil data penyewa
        // $kategoris = Kategori::all(); // Mengambil data kategori
        // Mengambil data tanggal laporan

        return view('laporan-keuangan.detail.create', compact('lokasiKos', 'kamars', 'transaksis', 'penyewas'));
        // Tampilan create dapat diatur sesuai dengan struktur modal tambah data yang telah Anda buat sebelumnya.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate input form fields (already implemented in your code)

        // Capture the selected values from the form
        $tanggal = date('Y-m-d', strtotime($request->input('tanggal')));
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $kamar = Kamar::findOrFail($request->input('kamar_id'));

        $lokasiKos = LokasiKos::findOrFail($request->input('lokasi_id'));
        $nama_kos = $lokasiKos->nama_kos;

        $tanggalInvestor = TanggalLaporan::where('nama_kos', $nama_kos)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if (!$tanggalInvestor) {
            // Redirect with an error message
            return redirect()->back()->with('error', 'Data TanggalInvestor belum tersedia untuk nama_kos, bulan, dan tahun ini');
        }
        // Initialize pemasukan and pengeluaran
        $prevPendapatanBersih = LaporanKeuangan::where('lokasi_id', $lokasiKos->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('id', 'desc')
            ->first();

        // Initialize pemasukan and pengeluaran
        $jenis = $request->input('jenis');
        $pemasukan = ($jenis === 'pemasukan') ? $request->input('pemasukan') : 0;
        $pengeluaran = ($jenis === 'pengeluaran') ? $request->input('pengeluaran') : 0;

        // Calculate pendapatanBersih
        if ($prevPendapatanBersih) {
            $pendapatanBersih = $prevPendapatanBersih->pendapatan_bersih + $pemasukan - $pengeluaran;
        } else {
            $pendapatanBersih = $pemasukan - $pengeluaran;
        }

        // Create a new LaporanKeuangan instance
        $laporanKeuangan = new LaporanKeuangan;

        // Fill in the required columns
        $laporanKeuangan->tanggal = $tanggal;
        $laporanKeuangan->bulan = $bulan;
        $laporanKeuangan->tahun = $tahun;
        $laporanKeuangan->kamar_id = $kamar->id;
        $laporanKeuangan->lokasi_id = $lokasiKos->id;
        $laporanKeuangan->jenis = $jenis;
        $laporanKeuangan->tipe_pembayaran = $request->input('tipe_pembayaran');
        $laporanKeuangan->bukti_pembayaran = $request->input('bukti_pembayaran');
        $laporanKeuangan->tanggal_pembayaran_awal = $request->input('tanggal_pembayaran_awal');
        $laporanKeuangan->tanggal_pembayaran_akhir = $request->input('tanggal_pembayaran_akhir');
        $laporanKeuangan->status_pembayaran = $request->input('status_pembayaran');
        $laporanKeuangan->keterangan = $request->input('keterangan');
        $laporanKeuangan->nama_kos = $nama_kos;

        // Assign pemasukan and pengeluaran directly to the database columns
        $laporanKeuangan->pemasukan = $pemasukan;
        $laporanKeuangan->pengeluaran = $pengeluaran;

        // Assign pendapatanBersih directly to the database column
        $laporanKeuangan->pendapatan_bersih = $pendapatanBersih;

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Appending timestamp to ensure uniqueness
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            // Change the directory name here
            $laporanKeuangan->bukti_pembayaran = $filePath; // Use -> instead of array notation
        } elseif ($request->input('tipe_pembayaran') === 'tunai') {
            $laporanKeuangan->bukti_pembayaran = 'Cash Payment'; // Use -> instead of array notation
        }
        // Save the data to the database

        if ($laporanKeuangan->save()) {
            // Update pendapatan bersih
            $this->updatePendapatanBersih($laporanKeuangan);

            // Redirect with success message
            return redirect()->route('laporan-keuangan.detail.show', [
                'lokasi_id' => $lokasiKos->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])->with('success_add', 'Berhasil menambahkan data');
        } else {
            // Redirect with an error message
            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDetail($lokasi_id, $bulan, $tahun)
    {

        $lokasiKos = LokasiKos::all();
        // Retrieve the TanggalLaporan record based on the given lokasi_id, bulan, and tahun
        $tanggalLaporan = TanggalLaporan::where('lokasi_id', $lokasi_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if (!$tanggalLaporan) {
            // Handle the case where no matching TanggalLaporan record is found
            return abort(404); // You can customize this as needed
        }

        // Use the relationship to retrieve related LaporanKeuangan data
        $laporanKeuangan = $tanggalLaporan->laporanKeuangan;


        return view('laporan-keuangan.detail.index', compact('laporanKeuangan', 'lokasiKos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);
        $prevPendapatanBersih = LaporanKeuangan::where('lokasi_id', $laporan->lokasi_id)
            ->where('tanggal', '<', $laporan->tanggal)
            ->orderBy('tanggal', 'desc')
            ->first();

        // Pass the data to the view
        return view('laporan-keuangan.detail.edit', [
            'laporan' => $laporan,
            'prevPendapatanBersihValue' => $prevPendapatanBersih ? $prevPendapatanBersih->pendapatan_bersih : 0,
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // LaporanKeuanganController.php

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'tanggal' => 'nullable|date',
            'jenis' => 'nullable|in:pemasukan,pengeluaran',
            'pemasukan' => 'nullable|numeric',
            'pengeluaran' => 'nullable|numeric',
            'tipe_pembayaran' => 'required|string',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'tanggal_pembayaran_awal' => 'nullable|date',
            'tanggal_pembayaran_akhir' => 'nullable|date',
            'status_pembayaran' => 'nullable|in:lunas,cicil,belum-lunas',
            'keterangan' => 'nullable|string',
        ]);
        

        // Find the laporan-keuangan by ID
        $laporan = LaporanKeuangan::findOrFail($id);
        $jenis = $request->input('jenis');
        $pemasukan = ($jenis === 'pemasukan') ? $request->input('pemasukan') : 0;
        $pengeluaran = ($jenis === 'pengeluaran') ? $request->input('pengeluaran') : 0;
        $prevPemasukan = LaporanKeuangan::where('lokasi_id', $laporan->lokasi_id)
            ->where('tanggal', '<', $laporan->tanggal)
            ->orderBy('tanggal', 'desc')
            ->value('pemasukan');
        $prevPengeluaran = LaporanKeuangan::where('lokasi_id', $laporan->lokasi_id)
            ->where('tanggal', '<', $laporan->tanggal)
            ->orderBy('tanggal', 'desc')
            ->value('pengeluaran');
        // Calculate pendapatanBersih
        $totalPemasukan = $prevPemasukan + $pemasukan;
        $totalPengeluaran = $prevPengeluaran + $pengeluaran;
        $pendapatan_bersih = $totalPemasukan - $totalPengeluaran;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            $laporan->bukti_pembayaran = $filePath;
        } elseif ($request->input('tipe_pembayaran') === 'tunai') {
            $laporan->bukti_pembayaran = null; // Set bukti_pembayaran to null for tunai payments
        }
        // dd($pendapatan_bersih);
        // Update the laporan-keuangan with the request data
        $laporan->update([
            'tanggal' => $request->input('tanggal'),
            'jenis' => $jenis,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'keterangan' => $request->input('keterangan'),
            'pendapatan_bersih' => $pendapatan_bersih,
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $laporan->bukti_pembayaran,
            'tanggal_pembayaran_awal' => $request->input('tanggal_pembayaran_awal'),
            'tanggal_pembayaran_akhir' => $request->input('tanggal_pembayaran_akhir'),
            'status_pembayaran' => $request->input('status_pembayaran'),
        ]);

        // Update pendapatan bersih
        $this->updatePendapatanBersih($laporan);

        // Redirect back with a success message
        return redirect()->back()->with('success_update', 'Data laporan keuangan berhasil diperbarui.');
    }

    private function updatePendapatanBersih($laporanKeuangan)
    {
        $lokasiId = $laporanKeuangan->lokasi_id;
        $bulan = $laporanKeuangan->bulan;
        $tahun = $laporanKeuangan->tahun;
    
        // Get all records for the given location, month, and year, ordered by date
        $laporanKeuanganRecords = LaporanKeuangan::where('lokasi_id', $lokasiId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();
    
        // Calculate and update pendapatan bersih for each record
        $prevPendapatanBersih = 0;
        foreach ($laporanKeuanganRecords as $record) {
            $record->update(['pendapatan_bersih' => $prevPendapatanBersih + $record->pemasukan - $record->pengeluaran]);
            $prevPendapatanBersih = $record->pendapatan_bersih;
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGenerateFinancialReportView()
    {
        // Fetch the necessary data for populating dropdowns, e.g., list of Kos, months, and years
        $lokasiKos = LokasiKos::all(); // Adjust the model and query as needed
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
        }

        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return view('laporan-keuangan.export', compact('lokasiKos', 'months', 'years'));
    }

    public function generateFinancialReport(Request $request)
    {
        // Validate the form data
        $lokasiKosId = $request->input('nama_kos');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Get the name of the selected kos (assuming you have a Kos model)
        $namaKos = LokasiKos::find($lokasiKosId)->nama_kos;

        // Get the name of the selected month
        $namaBulan = date("F", mktime(0, 0, 0, $bulan, 10));

        // Fetch the necessary data for populating dropdowns, e.g., list of Kos, months, and years
        $lokasiKos = LokasiKos::all(); // Adjust the model and query as needed
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
        }

        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        // Ensure that $laporanKeuangan is correctly populated with your data
        $laporanKeuangan = LaporanKeuangan::when($lokasiKosId, function ($query) use ($lokasiKosId) {
            return $query->where('lokasi_id', $lokasiKosId);
        })
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->get();

        // Create an instance of your export class with dynamic names
        $export = new LaporanKeuanganExport($laporanKeuangan, $namaKos, $namaBulan);

        // Generate and download the Excel file
        return Excel::download($export, 'laporan-keuangan.xlsx');
    }
    public function destroy($id)
    {
        // Find the LaporanKeuangan record by ID
        $laporanKeuangan = LaporanKeuangan::findOrFail($id);

        // Get the related data, such as lokasi_id, bulan, and tahun
        $lokasiId = $laporanKeuangan->lokasi_id;
        $bulan = $laporanKeuangan->bulan;
        $tahun = $laporanKeuangan->tahun;

        // Delete the LaporanKeuangan record
        if ($laporanKeuangan->delete()) {
            // Update pendapatan bersih after deletion
            $this->updatePendapatanBersihAfterDelete($lokasiId, $bulan, $tahun);

            // Redirect with success message
            return redirect()->back()->with('success_delete', 'Data laporan keuangan berhasil dihapus.');
        } else {
            // Redirect with an error message
            return redirect()->back()->with('error', 'Gagal menghapus data laporan keuangan.');
        }
    }
    private function updatePendapatanBersihAfterDelete($lokasiId, $bulan, $tahun)
    {
        // Get all records for the given location, month, and year
        $laporanKeuanganRecords = LaporanKeuangan::where('lokasi_id', $lokasiId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('tanggal')
            ->get();

        // Initialize the previous pendapatan bersih value
        $prevPendapatanBersih = 0;

        // Update pendapatan bersih for each record after deletion
        foreach ($laporanKeuanganRecords as $record) {
            $prevPendapatanBersih = $record->pendapatan_bersih = $prevPendapatanBersih + $record->pemasukan - $record->pengeluaran;
            $record->save();
        }
    }
}
