<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $expenditures = Pengeluaran::query();

        // Check if a search query is provided
        if ($request->has('katakunci')) {
            $keyword = $request->input('katakunci');
            $expenditures->where('nama_kos', 'like', '%' . $keyword . '%')
                ->orWhere('bulan', 'like', '%' . $keyword . '%')
                ->orWhere('tahun', 'like', '%' . $keyword . '%');
        }

        $expenditures = $expenditures->paginate(10); // You can adjust the number of records per page

        return view('pengeluaran.index', compact('expenditures', 'lokasiKos', 'months', 'years', 'kamars'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasiKos = LokasiKos::all(); // Fetch the data for $lokasiKos

        return view('pengeluaran.create', compact('lokasiKos'));
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
            'kamar_id' => 'required|string',
            'lokasi_id' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            // Add other validation rules as needed
        ]);

        // Create a new Pengeluaran instance
        $pengeluaran = new Pengeluaran([
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            // Add other fields as needed
        ]);
        $nama_kos = $pengeluaran->lokasiKos->nama_kos;
        // Save the Pengeluaran
        $pengeluaran->save();

        $tanggal = $pengeluaran->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        // Set the attributes for the new LaporanKeuangan instance
        $lastPendapatanBersih = LaporanKeuangan::where('lokasi_id', $pengeluaran->lokasi_id)
            ->orderBy('tanggal', 'desc')
            ->value('pendapatan_bersih');

        // If there's no previous record, set it to 0
        $lastPendapatanBersih = $lastPendapatanBersih ?? 0;

        // Calculate the new pendapatan_bersih
        $pendapatanBersih = $lastPendapatanBersih - $pengeluaran->jumlah;

        $laporanKeuanganAttributes = [
            'tanggal' => $tanggal,
            'kamar_id' => $pengeluaran->kamar_id,
            'lokasi_id' => $pengeluaran->lokasi_id,
            'jenis' => 'pengeluaran',
            'nama_kos' => $nama_kos,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pengeluaran' => $pengeluaran->jumlah,
            'pendapatan_bersih' => $pendapatanBersih,
            'keterangan' => $pengeluaran->keterangan,
        ];








        // Create a new LaporanKeuangan instance
        $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);

        // Save the new LaporanKeuangan instance
        $laporanKeuangan->save();

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenditure = Pengeluaran::findOrFail($id); // Assuming you're using Eloquent

        return view('pengeluaran.detail', compact('expenditure'));
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
