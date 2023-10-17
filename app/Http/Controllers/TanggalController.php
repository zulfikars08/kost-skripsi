<?php

namespace App\Http\Controllers;

use App\Models\TanggalTransaksi;
use App\Models\Transaksi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TanggalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lokasiId = $request->input('lokasi_id');
        $katakunci = $request->input('katakunci');
    
        $tanggalTransaksis = TanggalTransaksi::with('transaksi.lokasiKos')
            ->whereHas('transaksi', function ($query) use ($lokasiId) {
                $query->where('lokasi_id', $lokasiId);
            })
            ->when($katakunci, function ($query) use ($katakunci) {
                $query->whereHas('transaksi.lokasiKos', function ($subQuery) use ($katakunci) {
                    $subQuery->where('nama_kos', 'like', "%$katakunci%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Group the data by 'nama_kos' after retrieving it
        $groupedTransaksi = $tanggalTransaksis->groupBy(function ($item) {
            return optional(optional($item->transaksi)->lokasiKos)->nama_kos;
        });
    
        // Ensure $groupedTransaksi is always defined
        $groupedTransaksi = $groupedTransaksi ?? collect();
    
        return view('tanggal-transaksi.detail', compact('tanggalTransaksi', 'transaksiData', 'groupedTransaksi'));

    }
    

    
    

    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tanggal-transaksi.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//     public function store(Request $request)
// {
//     try {
//         $request->validate([
//             'bulan' => 'required|string',
//             'tahun' => 'required|string',
//         ]);

//         TanggalTransaksi::create([
//             'bulan' => $request->input('bulan'),
//             'tahun' => $request->input('tahun'),
//         ]);

//         return redirect()->route('tanggal-transaksi.index')->with('success', 'Data tanggal transaksi berhasil ditambahkan.');
//     } catch (QueryException $e) {
//         if ($e->errorInfo[1] == 1062) {
//             // Handle duplicate entry error
//             return redirect()->route('tanggal-transaksi.index')->with('error', 'Data tanggal transaksi sudah ada.');
//         }
//         throw $e; // Re-throw the exception if it's not a duplicate entry error
//     }
// }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Retrieve the 'TanggalTransaksi' record by ID
        $tanggalTransaksi = TanggalTransaksi::find($id);
    
        // Check if the record exists
        if (!$tanggalTransaksi) {
            return abort(404); // Handle the case where the record does not exist
        }
    
        // Extract the 'bulan' and 'tahun' values from the 'TanggalTransaksi' record
        $bulan = $tanggalTransaksi->bulan;
        $tahun = $tanggalTransaksi->tahun;
    
        // Retrieve transactions based on the 'tanggal' column within the specified month and year
        $transaksiData = Transaksi::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->join('lokasi_kos', 'transaksi.lokasi_id', '=', 'lokasi_kos.id')
            ->orderBy('tanggal', 'desc') // Order by 'tanggal' (date) in descending order
            ->orderBy('lokasi_kos.nama_kos') // Order by 'nama_kos'
            ->get();
    
        // Pass the data to the view
        return view('tanggal-transaksi.detail', compact('tanggalTransaksi', 'transaksiData'));
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
        // Find the TanggalTransaksi record by its ID
        $tanggalTransaksi = TanggalTransaksi::findOrFail($id);
    
        // Delete the record
        $tanggalTransaksi->delete();
    
        // Redirect back to the index page with a success message
        return redirect()->route('tanggal-transaksi.index')
            ->with('success_delete', 'Data tanggal transaksi berhasil dihapus.');
    }
}
