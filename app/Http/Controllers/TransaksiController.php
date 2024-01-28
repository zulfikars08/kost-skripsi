<?php

namespace App\Http\Controllers;

use App\Kamar;
use App\LokasiKos;
use App\Models\Kamar as ModelsKamar;
use App\Models\Penyewa;
use App\Models\TanggalTransaksi;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use App\Exports\TransaksiExport;
use App\Models\LokasiKos as ModelsLokasiKos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use App\Exports\FilteredTransaksiExport;
use App\Models\LaporanKeuangan;
use App\Models\Pemasukan;
use App\Models\TanggalInvestor;
use App\Models\TanggalLaporan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    public function index(Request $request)
    {
        // Retrieve all instances for dropdowns in the filter modal.
        $lokasiKosData = ModelsLokasiKos::all();
    
        // Generate month and year arrays for the dropdowns.
        $months = $this->getMonthsArray();
        $years = $this->getYearsArray();
    
        // Start the query builder.
         $query = Transaksi::query();

    // Add search criteria
    if ($request->filled('katakunci')) {
        $katakunci = $request->input('katakunci');
        $query->whereHas('penyewa', function ($q) use ($katakunci) {
            $q->where('nama', 'like', '%' . $katakunci . '%');
        });
    }

    // Apply filters if present.
    if ($request->filled('nama_kos')) {
        $query->whereHas('lokasiKos', function ($q) use ($request) {
            $q->where('nama_kos', $request->input('nama_kos'));
        });
    }
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal', '=', $request->bulan);
    }
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal', '=', $request->tahun);
    }
    if ($request->filled('status_pembayaran')) {
        $query->where('status_pembayaran', $request->status_pembayaran);
    }

    // Execute the query and get the results
    $transaksiData = Transaksi::with('penyewa')->paginate(5);

    // Check if the request is AJAX and return the appropriate view
    if ($request->ajax()) {
        return view('transaksi.list', compact('transaksiData'))->render();
    }

    
        // For the non-AJAX request, return the full view.
        return view('transaksi.index', compact('transaksiData', 'lokasiKosData', 'months', 'years'));
    }
    
    // Helper method to generate months array.
    private function getMonthsArray() {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
        }
        return $months;
    }
    
    // Helper method to generate years array.
    private function getYearsArray() {
        $currentYear = date('Y');
        return range($currentYear - 10, $currentYear);
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    try {
        DB::beginTransaction();

        $request->validate([
            'tanggal' => 'nullable|date',
            'jumlah_tarif' => ['required', 'regex:/^\d+(\,\d{1,3})*$/'],
            'tipe_pembayaran' => 'required|in:tunai,non-tunai',
            'tanggal_pembayaran_awal' => 'nullable|date',
            'tanggal_pembayaran_akhir' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'status_pembayaran' => 'required|in:lunas,belum_unas,cicil',
            'lokasi_id' => 'nullable|exists:lokasi_kos,id',
            'kamar_id' => 'nullable|exists:kamar,id',
            'penyewa_id' => 'nullable|exists:penyewa,id',
            // Add validation rules for other fields as needed
        ]);

        $jumlah_tarif = $request->filled('jumlah_tarif') ? intval(str_replace(',', '', $request->jumlah_tarif)) : 0;
      
        $data = [
            'tanggal' => $request->input('tanggal'),
            'jumlah_tarif' => str_replace(',', '', $request->input('jumlah_tarif')),
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),
            'tanggal_pembayaran_awal' => $request->input('tanggal_pembayaran_awal'),
            'tanggal_pembayaran_akhir' => $request->input('tanggal_pembayaran_akhir'),
            'keterangan' => $request->input('keterangan'),
            'status_pembayaran' => $request->input('status_pembayaran'),
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'penyewa_id' => $request->input('penyewa_id'),
            // 'bukti_pembayaran' will be handled below
        ];

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            $data['bukti_pembayaran'] = $filePath;
        } elseif ($request->input('tipe_pembayaran') === 'tunai') {
            $data['bukti_pembayaran'] = 'Cash Payment';
        }

        // Create a new Transaksi object
        $transaksi = new Transaksi($data);
        $transaksi->save();

        //Handle TanggalTransaksi association here, similar to the update method
        $nama_kos = $transaksi->lokasiKos->nama_kos;
        // Handle the creation of the Pemasukan record
        $pemasukan = [
            'nama_kos' => $nama_kos,
            'kamar_id' => $transaksi->kamar_id,
            'lokasi_id' => $transaksi->lokasi_id,
            'transaksi_id' => $transaksi->id,
            'jumlah' => $transaksi->jumlah_tarif,
            'tanggal_pembayaran_awal' => $transaksi->tanggal_pembayaran_awal,
            'tanggal_pembayaran_akhir' => $transaksi->tanggal_pembayaran_akhir,
            'status_pembayaran' =>$transaksi->status_pembayaran,
            'tanggal' => $transaksi->tanggal,
            'tipe_pembayaran' => $transaksi->tipe_pembayaran,
            'bukti_pembayaran' => $transaksi->bukti_pembayaran,
            'keterangan' => $transaksi->keterangan,
        ];

        $pemasukanModel = Pemasukan::where('transaksi_id', $transaksi->id)->first();
        if ($pemasukanModel) {
            $pemasukanModel->update($pemasukan);
        } else {
            Pemasukan::create($pemasukan);
        }

        DB::commit();
        $paginationSize = 5; // Change this to your actual pagination size
        $totalRecords = Transaksi::count();
        $lastPage = ceil($totalRecords / $paginationSize);

        return redirect()->route('transaksi.index', ['page' => $lastPage])
            ->with('success_add', 'Transaksi berhasil ditambahkan');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('transaksi.index')
            ->with('error', 'Gagal menambahkan Transaksi');
    }
}

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
    
            $request->validate([
                'tanggal' => 'nullable|date',
                'jumlah_tarif' => ['required', 'regex:/^\d+(\,\d{1,3})*$/'],
                'tipe_pembayaran' => 'required|in:tunai,non-tunai',
                'tanggal_pembayaran_awal' => 'nullable|date',
                'tanggal_pembayaran_akhir' => 'nullable|date',
                'keterangan' => 'nullable|string',
                'status_pembayaran' => 'required|in:lunas,belum_unas,cicil',
                'penyewa_id' => 'nullable|exists:penyewa,id',
                // Add validation rules for other fields as needed
            ]);
            // dd($request->all());
            $transaksi = Transaksi::findOrFail($id);
            $jumlah_tarif = $request->filled('jumlah_tarif') ? intval(str_replace(',', '', $request->jumlah_tarif)) : 0;
          
            $data = [
                'tanggal' => $request->input('tanggal'),
                'jumlah_tarif' => str_replace(',', '', $request->input('jumlah_tarif')),
                'tipe_pembayaran' => $request->input('tipe_pembayaran'),
                'bukti_pembayaran' => $request->input('bukti_pembayaran'),
                'tanggal_pembayaran_awal' => $request->input('tanggal_pembayaran_awal'),
                'tanggal_pembayaran_akhir' => $request->input('tanggal_pembayaran_akhir'),
                'keterangan' => $request->input('keterangan'),
                'status_pembayaran' => $request->input('status_pembayaran'),
                'penyewa_id' => $request->input('penyewa_id'),
                // Update other fields here
            ];
    
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
                $data['bukti_pembayaran'] = $filePath;
            } elseif ($request->input('tipe_pembayaran') === 'tunai') {
                $data['bukti_pembayaran'] = 'Cash Payment';
            }
            
            if (!is_null($request->input('tanggal'))) {
                $tanggal = Carbon::parse($request->input('tanggal'));
                $bulan = $tanggal->format('m');
                $tahun = $tanggal->format('Y');
    
                $tanggalTransaksi = TanggalTransaksi::firstOrNew([
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ]);
    
                if (!$tanggalTransaksi->exists) {
                    $tanggalTransaksi->save();
                }
    
                $transaksi->tanggalTransaksi()->associate($tanggalTransaksi);
            } else {
                $transaksi->tanggalTransaksi()->dissociate();
            }
    
            $transaksi->update($data);
    
            $nama_kos = $transaksi->lokasiKos->nama_kos;
    
            $pemasukanData = [
                'nama_kos' => $nama_kos,
                'kamar_id' => $transaksi->kamar_id,
                'lokasi_id' => $transaksi->lokasi_id,
                'transaksi_id' => $transaksi->id,
                'jumlah' => $transaksi->jumlah_tarif,
                'tanggal_pembayaran_awal' => $transaksi->tanggal_pembayaran_awal,
                'tanggal_pembayaran_akhir' => $transaksi->tanggal_pembayaran_akhir,
                'status_pembayaran' =>$transaksi->status_pembayaran,
                'tanggal' => $transaksi->tanggal,
                'tipe_pembayaran' => $transaksi->tipe_pembayaran,
                'bukti_pembayaran' => $transaksi->bukti_pembayaran,
                'keterangan' => $transaksi->keterangan,
            ];
    
            $pemasukanModel = $transaksi->updatePemasukan($pemasukanData);
            
            $laporanKeuanganData = [
                'tanggal' => $tanggal,
                'kamar_id' => $pemasukanModel->kamar_id, // Assuming you have these fields in your Pemasukan model
                'lokasi_id' => $pemasukanModel->lokasi_id,
                'transaksi_id' => $transaksi->id, 
                'pemasukan_id' => $pemasukanModel->id,
                'jenis' => 'pemasukan',
                'nama_kos' => $nama_kos,
                'kode_pemasukan' => $pemasukanModel->kode_pemasukan, // Assuming this field exists
                'tipe_pembayaran' => $pemasukanModel->tipe_pembayaran,
                'bukti_pembayaran' => $pemasukanModel->bukti_pembayaran,
                'status_pembayaran' => 'lunas',
                'bulan' => $bulan,
                'tahun' => $tahun,
                'pemasukan' => $pemasukanModel->jumlah,
                'keterangan' => $pemasukanModel->keterangan
            ];

              $tanggalLaporanAttributes = [
                'nama_kos' => $nama_kos,
                'kamar_id' => $pemasukanModel->kamar_id,
                'lokasi_id' => $pemasukanModel->lokasi_id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tanggal' => $pemasukanModel->tanggal,
            ];

            $tanggalInvestorAttributes = [
                'nama_kos' => $nama_kos,
                'lokasi_id' => $pemasukanModel->lokasi_id, 
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tanggal' => $pemasukanModel->tanggal,
            ];
            $transaksi->updateLaporanKeuangan($laporanKeuanganData);
            $transaksi->updateTanggalLaporan($tanggalLaporanAttributes);
            $transaksi->updateTanggalInvestor($tanggalInvestorAttributes);
            // dd($transaksi);die();
            DB::commit();
            return redirect()->route('transaksi.index')->with('success_update', 'Data Transaksi berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.index')->with('error', 'Gagal update data Transaksi');
        }
    }
    

    

    public function showGenerateFinancialReportView()
    {
        // Fetch the necessary data for populating dropdowns, e.g., list of Kos, months, and years
        $lokasiKosData = ModelsLokasiKos::all(); // Adjust the model and query as needed
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
        }

        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return view('transaksi.export', compact('lokasiKosData', 'months', 'years'));
    }

    public function generateFinancialReport(Request $request)
    {
        // Validate the form data
        $lokasiKosId = $request->input('nama_kos');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Get the name of the selected kos (assuming you have a Kos model)
        $namaKos = ModelsLokasiKos::find($lokasiKosId)->nama_kos;

        // Get the name of the selected month
        $namaBulan = date("F", mktime(0, 0, 0, $bulan, 10));

        // Perform data filtering based on the input values
        $filteredTransaksiData = Transaksi::when($lokasiKosId, function ($query) use ($lokasiKosId) {
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
        $export = new TransaksiExport($filteredTransaksiData, $namaKos, $namaBulan);

        // Generate and download the Excel file
        return Excel::download($export, 'transaksi.xlsx');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
    
            // Find the transaction by ID
            $transaksi = Transaksi::findOrFail($id);
    
            // Update the status of the related Penyewa
            $penyewa = $transaksi->penyewa; // Assuming a relationship is defined in the Transaksi model
            if ($penyewa) {
                $penyewa->status_penyewa = 'tidak_aktif';
                $penyewa->save();
            }

            $kamar = $transaksi->kamar; // Assuming a relationship is defined in the Transaksi model
            if ($kamar) {
                $kamar->status = 'Belum Terisi';
                $kamar->save();
            }
    
            // Delete associated Pemasukan if exists
            $pemasukan = Pemasukan::where('transaksi_id', $id)->first(); // Assuming a relationship or reference exists
            if ($pemasukan) {
                $pemasukan->delete();
            }
    
            // Delete the Transaksi
            $transaksi->delete();
    
            DB::commit();
            return redirect()->route('transaksi.index')->with('success_delete', 'Data transaksi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            // In case of an error, redirect back with an error message
            return redirect()->route('transaksi.index')->with('error', 'Gagal menghapus data transaksi');
        }
    }
    
}
