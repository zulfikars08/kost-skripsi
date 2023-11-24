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
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    public function index(Request $request)
    {

        $lokasiKosData = ModelsLokasiKos::all();
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
                ->paginate(5)
                ->withQueryString();
        } else {
            $transaksiData = Transaksi::paginate(5)->withQueryString();
        }

        $transaksiData = Transaksi::when($namaKos, function ($query) use ($namaKos) {
            return $query->whereHas('lokasiKos', function ($subQuery) use ($namaKos) {
                $subQuery->where('nama_kos', $namaKos);
            });
        })
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun);
            })
            ->when($statusPembayaran, function ($query) use ($statusPembayaran) {
                return $query->where('status_pembayaran', $statusPembayaran);
            })
            ->with('lokasiKos')
            ->paginate(5);




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
        // Validate the form data
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jumlah_tarif' => 'required|numeric',
            'tipe_pembayaran' => 'required|in:tunai,non-tunai',
            'kamar_id' => 'required|exists:kamar,id',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
        ]);
    
        // Create a new transaction
        $transaksi = new Transaksi;
        $transaksi->tanggal = $validatedData['tanggal'];
        $transaksi->jumlah_tarif = $validatedData['jumlah_tarif'];
        $transaksi->tipe_pembayaran = $validatedData['tipe_pembayaran'];
        $transaksi->kamar_id = $validatedData['kamar_id'];
        $transaksi->lokasi_id = $validatedData['lokasi_id'];
    
        // Add other fields as needed
    
        $transaksi->save();
    
        // You can add a success message or redirect to a different page
        return redirect()->route('transaksi.index')->with('success_add', 'Data transaksi berhasil ditambahkan');
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
                'jumlah_tarif' => 'required|numeric',
                'tipe_pembayaran' => 'required|in:tunai,non-tunai',
                'tanggal_pembayaran_awal' => 'nullable|date',
                'tanggal_pembayaran_akhir' => 'nullable|date',
                'keterangan' => 'required|string',
                'status_pembayaran' => 'required|in:lunas,belum_unas,cicil',
                // Add validation rules for other fields as needed
            ]);
    
            $transaksi = Transaksi::findOrFail($id);
    
            $data = [
                'tanggal' => $request->input('tanggal'),
                'jumlah_tarif' => $request->input('jumlah_tarif'),
                'tipe_pembayaran' => $request->input('tipe_pembayaran'),
                'bukti_pembayaran' => $request->input('bukti_pembayaran'),
                'tanggal_pembayaran_awal' => $request->input('tanggal_pembayaran_awal'),
                'tanggal_pembayaran_akhir' => $request->input('tanggal_pembayaran_akhir'),
                'keterangan' => $request->input('keterangan'),
                'status_pembayaran' => $request->input('status_pembayaran'),
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
    
            $pemasukan = [
                'nama_kos' => $nama_kos,
                'kamar_id' => $transaksi->kamar_id,
                'lokasi_id' => $transaksi->lokasi_id,
                'transaksi_id' => $transaksi->id,
                'jumlah' => $transaksi->jumlah_tarif,
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
