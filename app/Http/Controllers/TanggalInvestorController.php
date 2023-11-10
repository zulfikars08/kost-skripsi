<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\TanggalInvestor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
        
        $investors = $investorsQuery->get();
        
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
            'jumlah_investor' => 'required|integer',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
            'bulan' => 'required|date_format:m', // Validate 'bulan' as a two-digit month format 'mm'
            'tahun' => 'required|date_format:Y', // Validate 'tahun' as a four-digit year format 'YYYY'
        ]);
    
        $lokasiKos = LokasiKos::findOrFail($request->input('lokasi_id'));
        
        // Check if a record with the same 'nama_kos', 'bulan', and 'tahun' already exists
        $existingRecord = TanggalInvestor::where('nama_kos', $lokasiKos->nama_kos)
            ->where('bulan', $request->input('bulan'))
            ->where('tahun', $request->input('tahun'))
            ->first();
    
        if ($existingRecord) {
            // A record with the same 'nama_kos', 'bulan', and 'tahun' already exists
            return redirect()->route('investor.index')->with('error', 'Data Tanggal Laporan sudah ada.');
        }
        
        // Create a new Investor instance
        $tanggalInvestor = new TanggalInvestor;
        $tanggalInvestor->lokasi_id = $lokasiKos->id;
        $tanggalInvestor->tahun = $request->input('tahun');
        $tanggalInvestor->bulan = $request->input('bulan');
        $tanggalInvestor->jumlah_investor = $request->input('jumlah_investor');
        $tanggalInvestor->nama_kos = $lokasiKos->nama_kos;
    
        // Save the TanggalInvestor record to the database
        $tanggalInvestor->save();
    
        return redirect()->route('investor.index')->with('success_add', 'Data Tanggal Laporan berhasil disimpan.');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lokasi_id, $bulan, $tahun) {
        // Get all available Lokasi Kos
        $lokasiKos = LokasiKos::all();
    
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT);
            $monthName = date("F", mktime(0, 0, 0, $i, 1));
            $months[$monthValue] = $monthName;
        }
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        // Retrieve the TanggalLaporan record based on the given lokasi_id, bulan, and tahun
        $tanggalInvestor = TanggalInvestor::where('lokasi_id', $lokasi_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
    
        if (!$tanggalInvestor) {
            // Handle the case where no matching TanggalLaporan record is found
            return abort(404); // You can customize this as needed
        }
    
        // Use the relationship to retrieve related LaporanKeuangan data
        $investors = $tanggalInvestor->investor;
    
        // Convert the collection to a paginator
        $page = request('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $investors = new LengthAwarePaginator(
            $investors->slice($offset, $perPage), // Sliced results for the current page
            $investors->count(), // Total count of results
            $perPage, // Results per page
            $page, // Current page
            ['path' => request()->url(), 'query' => request()->query()]
        );
    
        return view('investor.detail.index', compact('investors', 'lokasiKos', 'years', 'months'));
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
        //
    }
}
