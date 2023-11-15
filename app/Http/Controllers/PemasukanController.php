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
            'tipe_pembayaran' => 'required|in:tunai,non-tunai', // Adjust the 'in' rule based on your options
            'bukti_pembayaran' => 'required_if:tipe_pembayaran,non-tunai|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            // Add other validation rules as needed
        ]);

        // Create a new Pengeluaran instance
        $pemasukan = new Pemasukan([
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'tanggal' => $request->input('tanggal'),
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),         
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            // Add other fields as needed
        ]);
        $nama_kos = $pemasukan->lokasiKos->nama_kos;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Appending timestamp to ensure uniqueness
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            // Change the directory name here
            $pemasukan->bukti_pembayaran = $filePath; // Use -> instead of array notation
        } elseif ($request->input('tipe_pembayaran') === 'tunai') {
            $pemasukan->bukti_pembayaran = 'Cash Payment'; // Use -> instead of array notation
        }
        // Save the Pengeluaran
        $pemasukan->save();

        $tanggal = $pemasukan->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $laporanKeuanganAttributes = [
            'tanggal' => $tanggal,
            'kamar_id' => $pemasukan->kamar_id,
            'lokasi_id' => $pemasukan->lokasi_id,
            'pemasukan_id' => $pemasukan->id,
            'jenis' => 'pemasukan',
            'nama_kos' => $nama_kos,
            'tipe_pembayaran' => $pemasukan->tipe_pembayaran,
            'bukti_pembayaran' => $pemasukan->bukti_pembayaran,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pemasukan' => $pemasukan->jumlah,
            'keterangan' => $pemasukan->keterangan,
        ];

        // Create a new LaporanKeuangan instance
        $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);
        
        // Save the new LaporanKeuangan instance
        $laporanKeuangan->save();

        return redirect()->route('pemasukan.index')->with('success_add', 'Data pemasukan berhasil ditambahkan.');
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
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),  
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            // Add other validation rules as needed
        ]);
    
        $pemasukan = Pemasukan::findOrFail($id);
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Appending timestamp to ensure uniqueness
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            // Change the directory name here
            $pemasukan->bukti_pembayaran = $filePath; // Use -> instead of array notation
        } elseif ($request->input('tipe_pembayaran') === 'tunai') {
            $pemasukan->bukti_pembayaran = 'Cash Payment'; // Use -> instead of array notation
        }
        
        $pemasukan->update([
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'tanggal' => $request->input('tanggal'),
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'), 
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            // Add other fields as needed
        ]);

        
    
        return redirect()->route('pemasukan.index')->with('success_update', 'Data pemasukan berhasil diupdate.');
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
