<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $kamars = Kamar::all();
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
        // Retrieve expenditures and apply any search filter if provided
        $pemasukan = Pemasukan::query();

        // Check if a search query is provided
        if ($request->has('katakunci')) {
            $keyword = $request->input('katakunci');
            $pemasukan->where('nama_kos', 'like', '%' . $keyword . '%')
                ->orWhere('bulan', 'like', '%' . $keyword . '%')
                ->orWhere('tahun', 'like', '%' . $keyword . '%');
        }

        if ($request->ajax()) {
            $pemasukan = $pemasukan->get(); // Get all records without pagination for AJAX request
        } else {
            $pemasukan = $pemasukan->paginate(10); // Paginate results for non-AJAX request
        } // You can adjust the number of records per page

        return view('pemasukan.index', compact('pemasukan', 'lokasiKos', 'months', 'years', 'kamars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $lokasiKos = LokasiKos::all(); // Fetch the data for $lokasiKos

        return view('pemasukan.create', compact('lokasiKos'));
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
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            // Add other validation rules as needed
        ]);

        // Create a new Pengeluaran instance
        $pemasukan = new Pemasukan([
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            // Add other fields as needed
        ]);
        $nama_kos = $pemasukan->lokasiKos->nama_kos;
        // Save the Pengeluaran
        $pemasukan->save();

        $tanggal = $pemasukan->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        // Set the attributes for the new LaporanKeuangan instance
        $lastPendapatanBersih = LaporanKeuangan::where('lokasi_id', $pemasukan->lokasi_id)
            ->orderBy('tanggal', 'desc')
            ->value('pendapatan_bersih');

        // If there's no previous record, set it to 0
        $lastPendapatanBersih = $lastPendapatanBersih ?? 0;

        // Calculate the new pendapatan_bersih
        $pendapatanBersih = $lastPendapatanBersih + $pemasukan->jumlah;

        $laporanKeuanganAttributes = [
            'tanggal' => $tanggal,
            'kamar_id' => $pemasukan->kamar_id,
            'lokasi_id' => $pemasukan->lokasi_id,
            'jenis' => 'pemasukan',
            'nama_kos' => $nama_kos,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pemasukan' => $pemasukan->jumlah,
            'pendapatan_bersih' => $pendapatanBersih,
            'keterangan' => $pemasukan->keterangan,
        ];

        // Create a new LaporanKeuangan instance
        $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);

        // Save the new LaporanKeuangan instance
        $laporanKeuangan->save();

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil ditambahkan.');
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
        $pemasukan = Pemasukan::findOrFail($id);
        $lokasiKos = LokasiKos::all();
        $kamars = Kamar::all();

        return view('pemasukan.edit', compact('pemasukan', 'lokasiKos', 'kamars'));
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
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            // Add other validation rules as needed
        ]);
    
        $pemasukan = Pemasukan::findOrFail($id);
        $nama_kos = $pemasukan->lokasiKos->nama_kos;
    
        // Store the previous pemasukan amount for deducting later
        $previousPemasukanAmount = $pemasukan->jumlah;
    
        $pemasukan->update([
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            // Add other fields as needed
        ]);
    
        $tanggal = $pemasukan->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
    
        // Update the attributes for the related LaporanKeuangan instance
        $lastPendapatanBersih = LaporanKeuangan::where('lokasi_id', $pemasukan->lokasi_id)
            ->orderBy('tanggal', 'desc')
            ->value('pendapatan_bersih');
    
        $lastPendapatanBersih = $lastPendapatanBersih ?? 0;
    
        // Deduct the previous pemasukan amount
        $pendapatanBersih = $lastPendapatanBersih - $previousPemasukanAmount + $pemasukan->jumlah;
    
        $laporanKeuangan = LaporanKeuangan::where([
            'kamar_id' => $pemasukan->kamar_id,
            'lokasi_id' => $pemasukan->lokasi_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ])->first();
    
        if ($laporanKeuangan) {
            $laporanKeuangan->update([
                'tanggal' => $tanggal,
                'jenis' => 'pemasukan',
                'nama_kos' => $nama_kos,
                'pemasukan' => $pemasukan->jumlah,
                'pendapatan_bersih' => $pendapatanBersih,
                'keterangan' => $pemasukan->keterangan,
            ]);
        }
    
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diupdate.');
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
