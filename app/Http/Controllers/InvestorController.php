<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\TanggalInvestor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvestorController extends Controller
{
    //
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $lokasi_id = $request->input('lokasi_id'); // Updated to match the input field name
        $nama = $request->input('nama');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT);
            $monthName = date("F", mktime(0, 0, 0, $i, 1));
            $months[$monthValue] = $monthName;
        }
    
        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
    
        // Fetch necessary data from the database
        $lokasiKos = LokasiKos::all();
        $laporanKeuangan = LaporanKeuangan::all();
        $tanggalInvestor = TanggalInvestor::all();
        $uniqueNamaKos = Investor::select('nama_kos')
            ->distinct()
            ->pluck('nama_kos');
    
        $investors = collect();
    
        foreach ($uniqueNamaKos as $namaKos) {
            $investor = Investor::where('nama_kos', $namaKos)
                ->get();
            $investors = $investors->concat($investor);
        }
    
        // Start a new query to filter the data
        $query = Investor::query();
    
        // Apply filters
        if ($lokasi_id) {
            $query->where('lokasi_id', $lokasi_id);
        }
    
        if ($bulan) {
            $query->where('bulan', $bulan);
        }
    
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        if ($nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }
    
        // Get the filtered data
        $investor = $query->get();
    
        // Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $items = $investor->forPage($page, $perPage);
        $investors = new LengthAwarePaginator($items, $investor->count(), $perPage, $page);
    
        return view('investor.detail.index', compact('investors', 'lokasiKos', 'laporanKeuangan', 'months', 'years', 'tanggalInvestor'));
    }
    



    

    
    public function create()
    {
        // Retrieve a list of available Lokasi Kos for the dropdown
        $lokasiKos = LokasiKos::all();

        return view('investor.detail.create', compact('lokasiKos'));
    }

    public function store(Request $request)
    {
        $bulan = date('m', strtotime($request->input('bulan')));
        $tahun = date('Y', strtotime($request->input('tahun')));
        $request->validate([
    'nama' => 'required|string',
    'jumlah_pintu' => 'required|integer',
    'lokasi_id' => 'required|exists:lokasi_kos,id',
    'bulan' => 'required|date_format:m', // 'm' represents the month format 'mm'
    'tahun' => 'required|date_format:Y',
]);

// Create a new investor record
$investor = new Investor();
$investor->nama = $request->input('nama');
$investor->jumlah_pintu = $request->input('jumlah_pintu');
$investor->bulan = $bulan;
$investor->tahun = $tahun;
$investor->lokasi_id = $request->input('lokasi_id');

// Set the 'nama_kos' column with the value of 'lokasi_id'
$lokasiKos = LokasiKos::find($request->input('lokasi_id'));
if ($lokasiKos) {
    $investor->nama_kos = $lokasiKos->nama_kos;
}

// Find the last "pendapatan_bersih" from "laporan_keuangan" for the same "nama_kos," "bulan," and "tahun"
$lastPendapatanBersih = LaporanKeuangan::where('nama_kos', $investor->nama_kos)
    ->where('bulan', $bulan)
    ->where('tahun', $tahun)
    ->orderBy('id', 'desc')
    ->value('pendapatan_bersih');

// Assign the last "pendapatan_bersih" value to the investor record
$investor->pendapatan_bersih = $lastPendapatanBersih;

if ($investor->save()) {
    // Redirect with success message to a dynamic route
    return redirect()->route('investor.detail.index', [
        'lokasi_id' => $lokasiKos->id,
        'bulan' => $investor->bulan,
        'tahun' => $investor->tahun,
    ])->with('success_add', 'Berhasil menambahkan data');
} else {
    // Redirect with an error message
    return redirect()->back()->with('error', 'Gagal menambahkan data');
}
        return redirect()->route('investor.detail.index')->with('success_add', 'Investor added successfully');
    }

    public function show($lokasi_id, $bulan, $tahun) {
        // Fetch the data you need for the view
        $investors = Investor::where('lokasi_id', $lokasi_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();
    
        $lokasiKos = LokasiKos::find($lokasi_id);
    
        return view('investor.detail.show', compact('investors', 'lokasiKos', 'bulan', 'tahun'));
    }
}

