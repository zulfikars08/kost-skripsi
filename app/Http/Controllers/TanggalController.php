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
    public function index()
    {
        $tanggalTransaksis = TanggalTransaksi::all();
        return view('tanggal-transaksi.index', compact('tanggalTransaksis'));
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
        $tanggalTransaksi = TanggalTransaksi::findOrFail($id);
    
        // Extract the 'bulan' and 'tahun' values from the 'TanggalTransaksi' record
        $bulan = $tanggalTransaksi->bulan;
        $tahun = $tanggalTransaksi->tahun;
    
        // Retrieve transactions based on the 'tanggal' column within the specified month and year
        $transaksiData = Transaksi::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
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
