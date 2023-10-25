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
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $lokasiKosData = ModelsLokasiKos::all();
    
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
            // ... (your month data creation)
        }
        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
    
        // Check for the search query
        if ($request->has('katakunci')) {
            $katakunci = $request->input('katakunci');
            $transaksiData = Transaksi::where('nama_kos', 'like', '%' . $katakunci . '%')
                ->orWhereHas('penyewa', function ($query) use ($katakunci) {
                    $query->where('nama', 'like', '%' . $katakunci . '%');
                })
                ->orWhereHas('lokasiKos', function ($query) use ($katakunci) {
                    $query->where('nama_kos', 'like', '%' . $katakunci . '%');
                })
                ->orWhereHas('kamar', function ($query) use ($katakunci) {
                    $query->where('no_kamar', 'like', '%' . $katakunci . '%');
                })
                ->paginate(10)
                ->withQueryString();
        } else {
            $transaksiData = Transaksi::paginate(10)->withQueryString();
        }
    
        
        
        
    
        // Tampilkan view 'transaksi.index' and kirimkan data transaksi
        return view('transaksi.index', compact('lokasiKosData', 'transaksiData', 'months', 'years'));
    
        
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
        //
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
        // Validate the request
        $request->validate([
            'tanggal' => 'nullable|date',
            'jumlah_tarif' => 'required|numeric',
            'kebersihan' => 'required|numeric',
            // 'pengeluaran' => 'required|numeric',
            'tipe_pembayaran' => 'required|in:tunai,non-tunai',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,pdf',
            'tanggal_pembayaran_awal' => 'nullable|date',
            'tanggal_pembayaran_akhir' => 'nullable|date',
            // 'keterangan' => 'required|string',
            'status_pembayaran' => 'required|in:lunas,belum_lunas,cicil',
            // Add validation rules for other fields as needed
        ]);

        // Find the Transaksi record by ID
        $transaksi = Transaksi::findOrFail($id);

        // Prepare the data for updating the Transaksi record
        $data = [
            'tanggal' => $request->input('tanggal'),
            'jumlah_tarif' => $request->input('jumlah_tarif'),
            'kebersihan' => $request->input('kebersihan'),
            // 'pengeluaran' => $request->input('pengeluaran'),
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),
            'tanggal_pembayaran_awal' => $request->input('tanggal_pembayaran_awal'),
            'tanggal_pembayaran_akhir' => $request->input('tanggal_pembayaran_akhir'),
            // 'keterangan' => $request->input('keterangan'),
            'status_pembayaran' => $request->input('status_pembayaran'),
            // Update other fields here
        ];

        // Handle file upload (if a file is provided)
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            $data['bukti_pembayaran'] = $filePath;
        }

        // Check if the 'tanggal' field is not null
        if (!is_null($request->input('tanggal'))) {
            // Extract the year and month from the 'tanggal' column
            $tanggal = Carbon::parse($request->input('tanggal'));
            $bulan = $tanggal->format('m'); // Extract the month in 'MM' format
            $tahun = $tanggal->format('Y'); // Extract the year in 'YYYY' format

            // Find or create the TanggalTransaksi record based on month and year
            $tanggalTransaksi = TanggalTransaksi::firstOrNew([
                'bulan' => $bulan,
                'tahun' => $tahun,
            ]);

            // Save the TanggalTransaksi record if it's new
            if (!$tanggalTransaksi->exists) {
                $tanggalTransaksi->save();
            }

            // Associate the Transaksi record with the TanggalTransaksi record
            $transaksi->tanggalTransaksi()->associate($tanggalTransaksi);
        } else {
            // If 'tanggal' is null, disassociate the Transaksi record from any TanggalTransaksi record
            $transaksi->tanggalTransaksi()->dissociate();
        }

        // Update the Transaksi record with the prepared data
        $transaksi->update($data);

        return redirect()->route('transaksi.index')->with('success_add', 'Data Transaksi berhasil diupdate.');
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
        return Excel::download($export, 'laporan-keuangan.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
