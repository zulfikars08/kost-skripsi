<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use App\Models\TanggalLaporan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TanggalLaporanController extends Controller
{
    public function index(Request $request)
    {
    
        $lokasiKos = LokasiKos::all();
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
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
        // Retrieve and filter data based on search criteria.
        $query = TanggalLaporan::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_kos', 'like', '%' . $search . '%')
                ->orWhere('bulan', 'like', '%' . $search . '%')
                ->orWhere('tahun', 'like', '%' . $search . '%');
        }

        $tanggalLaporan = $query->paginate(5);

        return view('laporan-keuangan.index', compact('tanggalLaporan','lokasiKos','months','years'));
    }

    public function create()
    {
        // Return a view for adding new data (e.g., the modal form).
        return view('laporan-keuangan.create');
    }

    public function store(Request $request)
    {
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'lokasi_id' => 'required|exists:lokasi_kos,id', // Ensure the selected lokasi_kos exists
            'bulan' => 'required|date_format:m', // 'm' represents the month format 'mm'
            'tahun' => 'required|date_format:Y',
        ]);

        $lokasiKos = LokasiKos::findOrFail($request->input('lokasi_id'));
        
        $existingRecord = TanggalLaporan::where('nama_kos', $lokasiKos->nama_kos)
        ->where('bulan', $validatedData['bulan'])
        ->where('tahun', $validatedData['tahun'])
        ->first();

        if ($existingRecord) {
        // A record with the same nama_kos, bulan, and tahun already exists
        return redirect()->route('laporan-keuangan.index')->with('error', 'Data Tanggal Laporan sudah ada.');
        }
        // Menghubungkan nama_kos dengan lokasi yang sesuai
        $nama_kos = $lokasiKos->nama_kos;

        // Create a new TanggalLaporan instance and fill it with the validated data
        $tanggalLaporan = new TanggalLaporan;
        $tanggalLaporan ->lokasi_id = $lokasiKos->id;
        $tanggalLaporan->tahun = $validatedData['tahun'];
        $tanggalLaporan->bulan = $validatedData['bulan'];
      
        $tanggalLaporan->nama_kos = $nama_kos;
        // Save the TanggalLaporan record to the database
        $tanggalLaporan->save();

        // Redirect back or to a specific page with a success message
        return redirect()->route('laporan-keuangan.index')->with('success_add', 'Data Tanggal Laporan berhasil disimpan');
    }

    public function showDetail($lokasi_id, $bulan, $tahun)
    {
      
        $lokasiKos = LokasiKos::all();
        $kamars = Kamar::all(); // Mengambil data nomor kamar
        $transaksis = Transaksi::all(); // Mengambil data transaksi
        $penyewas = Penyewa::all();
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
    
        return view('laporan-keuangan.detail.index', compact('laporanKeuangan','lokasiKos', 'kamars', 'transaksis', 'penyewas','months','years'));
    }

    public function destroy($id)
{
    // Start a database transaction
    DB::beginTransaction();

    try {
        // Find the TanggalLaporan by ID
        $tanggalLaporan = TanggalLaporan::find($id);

        // Check if the TanggalLaporan exists
        if (!$tanggalLaporan) {
            DB::rollback();
            return redirect()->back()->with('error', 'Tanggal Laporan tidak ditemukan');
        }

        // Perform any necessary pre-deletion logic
        // (e.g., updating related models, checking dependencies)

        // Delete the TanggalLaporan
        $tanggalLaporan->delete();

        // Commit the transaction
        DB::commit();
        return redirect()->route('laporan-keuangan.index')->with('success_delete', 'Tanggal Laporan berhasil dihapus');
    } catch (\Exception $e) {
        // Rollback the transaction in case of an error
        DB::rollback();
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Tanggal Laporan');
    }
}
    // public function show($id)
    // {
    //     // Retrieve and display details of a specific "tanggal_laporan" entry.
    //     $tanggalLaporan = TanggalLaporan::findOrFail($id);

    //     return view('tanggal_laporan.show', compact('tanggalLaporan'));
    // }
}
