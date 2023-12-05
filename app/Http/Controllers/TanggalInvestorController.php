<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\TanggalInvestor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TanggalInvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $tanggalInvestor = TanggalInvestor::all();
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
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
        $namaKos = $request->query('nama_kos');
        $lokasiKos = LokasiKos::all();
        $laporanKeuangan = LaporanKeuangan::all();
        
        $investorsQuery = TanggalInvestor::query();
        
        // Apply the filter based on the selected 'nama_kos' if it's provided
        if ($namaKos) {
            $investorsQuery->where('nama_kos', $namaKos);
        }
        
        $investors = $investorsQuery->paginate(5);
        
        return view('investor.index', compact('investors', 'lokasiKos', 'laporanKeuangan','months','years','tanggalInvestor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tanggalInvestor = TanggalInvestor::all();
        $lokasiKos = LokasiKos::all();

        return view('investor.create', compact('lokasiKos','tanggalInvestor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi_id' => 'required|exists:lokasi_kos,id',
            'bulan' => 'required|date_format:m',
            'tahun' => 'required|date_format:Y',
        ]);
    
        $lokasiKos = LokasiKos::findOrFail($request->input('lokasi_id'));
    
        // Check if a record with the same 'nama_kos', 'bulan', and 'tahun' already exists
        $existingRecord = TanggalInvestor::where('nama_kos', $lokasiKos->nama_kos)
            ->where('bulan', $request->input('bulan'))
            ->where('tahun', $request->input('tahun'))
            ->first();
    
        if ($existingRecord) {
            return redirect()->route('investor.index')->with('error', 'Data Tanggal Laporan sudah ada.');
        }
    
        // Count the number of investors for the given LokasiKos
    
        // Create a new TanggalInvestor instance
        $tanggalInvestor = new TanggalInvestor;
        $tanggalInvestor->lokasi_id = $lokasiKos->id;
        $tanggalInvestor->tahun = $request->input('tahun');
        $tanggalInvestor->bulan = $request->input('bulan');
        $tanggalInvestor->nama_kos = $lokasiKos->nama_kos;
    
        // Save the TanggalInvestor record to the database
        $tanggalInvestor->save();
    
        return redirect()->route('investor.index')->with('success_add', 'Data Tanggal Laporan berhasil disimpan');
    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Start a database transaction
        DB::beginTransaction();
    
        try {
            // Find the TanggalInvestor by ID
            $tanggalInvestor = TanggalInvestor::find($id);
    
            // Check if the TanggalInvestor exists
            if (!$tanggalInvestor) {
                return redirect()->back()->with('error', 'TanggalInvestor tidak ditemukan');
            }
    
            // Perform any necessary pre-deletion logic
            // (e.g., updating related models, checking dependencies)
    
            // Delete the TanggalInvestor
            $tanggalInvestor->delete();
    
            // Commit the transaction
            DB::commit();
            return redirect()->route('investor.index')->with('success_delete', 'TanggalInvestor berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus TanggalInvestor');
        }
    }
}
