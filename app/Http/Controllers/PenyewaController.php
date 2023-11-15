<?php

namespace App\Http\Controllers;

use App\Events\PenyewaCreated;
use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penghuni;
use App\Models\Penyewa;
use App\Models\Transaksi;
use App\Rules\UniqueNoKamarNamaKos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function index(Request $request)
     {
         // Retrieve all Penyewa records from the database
         $penyewas = Penyewa::paginate(5); // You can adjust the number of records per page
     
         // If a search keyword is provided, filter the results
         if ($request->has('katakunci')) {
             $katakunci = $request->input('katakunci');
             $penyewas = Penyewa::where('nama', 'like', '%' . $katakunci . '%')
                 ->paginate(5); // You can adjust the number of records per page for search results
         }
         $kamars = Kamar::all();
         $lokasiKos = LokasiKos::all();
         
         // Load the view and pass the data to it
         return view('penyewa.index', compact('penyewas', 'lokasiKos','kamars'));
     }
     
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasiKos = LokasiKos::all(); // Retrieve the data you need
        return view('penyewa.create', ['lokasiKos' => $lokasiKos]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            // 'no_kamar' => 'nullable|string',
            'penghuni_id' => 'nullable|exists:penghuni,id',
            'lokasi_id' => 'nullable|exists:lokasi_kos,id',
            'kamar_id' => 'nullable|exists:kamar,id',
            'status_penyewa' => 'required|in:aktif,tidak_aktif',
        ]);
        
        // Get the latest penyewa_id
        $latestPenyewa = Penyewa::latest('kode_penyewa')->first();
    
        // Extract the numeric part of penyewa_id and increment it
        $penyewaIdNumeric = $latestPenyewa ? (int)str_replace('PY', '', $latestPenyewa->kode_penyewa) + 1 : 1;
    
        // Format penyewa_id with 'PY' prefix and leading zeros
        $penyewaId = 'PY' . str_pad($penyewaIdNumeric, 3, '0', STR_PAD_LEFT);

        // $existingKamar = Kamar::where('no_kamar', $request->input('no_kamar'))
        // ->where('lokasi_id', $request->input('lokasi_id'))
        // ->first();

        // if (!$existingKamar) {
        // return redirect()->back()->with('error', 'No Kamar tidak ditemukan.');
        // }
    
        // Prepare the data for creating a new Penyewa record
        $data = [
            'kode_penyewa' => $penyewaId, // Assign the unique penyewa_id
            'nama' => $request->input('nama'),
            // 'no_kamar' => $request->input('no_kamar'),
            // 'nama_kos' => LokasiKos::findOrFail($request->input('lokasi_id'))->nama_kos,
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'status_penyewa' => $request->input('status_penyewa'),
        ];
        // Check if the 'status_penyewa' is "aktif"
        if ($data['status_penyewa'] === 'aktif') {
            // Check if there is a Penyewa record with the same 'no_kamar' and 'lokasi_id' and an active status ('aktif')
            $existingActivePenyewa = Penyewa::where('kamar_id', $data['kamar_id'])
                ->where('lokasi_id', $data['lokasi_id'])
                ->where('status_penyewa', 'aktif')
                ->first();
    
            if ($existingActivePenyewa) {
                // A Penyewa record with the same 'no_kamar' and 'lokasi_id' and active status ('aktif') exists.
                // Redirect back with an error message or handle it as needed.
                return redirect()->back()->with('error', 'No Kamar sudah digunakan oleh penyewa aktif.');
            }
    
            // Update the Kamar status to "sudah terisi" based on the provided 'no_kamar' and 'lokasi_id'
            Kamar::where('id', $data['kamar_id']) // Assuming 'id' is the primary key column in the 'kamar' table
    ->where('lokasi_id', $data['lokasi_id'])
    ->update(['status' => 'sudah terisi']);

        }
    
        // Create the Penyewa record
        $penyewa = Penyewa::create($data);
    
        // Automatically create a record in the 'transaksi' table
        Transaksi::create([
            'nama' => $penyewa->nama,
            'kamar_id' => $penyewa->kamar_id,
            'lokasi_id' => $penyewa->lokasi_id,
            'penyewa_id' => $penyewa->id, // Assign the penyewa_id
            // Set the default value or adjust as needed
            'jumlah_tarif' => 0,
           // Set to '-' for string columns
            'tanggal' => null,
            'tipe_pembayaran' => null, // Set to 0 for integer columns
            'bukti_pembayaran' => null,
            'tanggal_pembayaran_awal' => null, // Set to the current date or adjust as needed
            'tanggal_pembayaran_akhir' => null, // Set to the current date or adjust as needed
            'status_pembayaran' => null, // Set the default value or adjust as needed
            'kebersihan' => 0, // Set to 0 for integer columns
            'pengeluaran' => 0, // Set to 0 for integer columns
            'keterangan' => '-', // Set to '-' for string columns
        ]);
    
        // Redirect to the index page with a success message
        return redirect()->route('penyewa.index')->with('success_add', 'Data penyewa berhasil ditambahkan.');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil daftar penghuni terkait dengan penyewa tertentu dengan pagination
        $penghuniList = Penghuni::where('penyewa_id', $id)->paginate(10); // Sesuaikan jumlah item per halaman (10 di sini)

        // Hitung jumlah penghuni
        $jumlahPenghuni = $penghuniList->total();

        // Kirim data penghuni dan jumlah penghuni ke view
        $penyewa = Penyewa::findOrFail($id);
        return view('penyewa.penghuni.index', ['penghuniList' => $penghuniList, 'jumlahPenghuni' => $jumlahPenghuni], compact('penyewa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasiKos = LokasiKos::all(); 
        $penyewa = Penyewa::findOrFail($id);
    
        return view('penyewa.edit', compact('penyewa', 'lokasiKos'));
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
            'status_penyewa' => 'required|in:aktif,tidak_aktif',
        ]);
    
        $penyewa = Penyewa::findOrFail($id);
    
        // Check if the status is being changed from "aktif" to "tidak aktif"
        if ($request->status_penyewa === 'tidak_aktif' && $penyewa->status_penyewa === 'aktif') {
            // Restore the Kamar status to "belum terisi" based on the provided 'no_kamar' and 'lokasi_id'
            Kamar::where('no_kamar', $penyewa->no_kamar)
                ->where('lokasi_id', $penyewa->lokasi_id)
                ->update(['status' => 'belum terisi']);
        } elseif ($request->status_penyewa === 'aktif' && $penyewa->status_penyewa === 'tidak_aktif') {
            // Update the Kamar status to "sudah terisi" based on the provided 'no_kamar' and 'lokasi_id'
            Kamar::where('no_kamar', $penyewa->no_kamar)
                ->where('lokasi_id', $penyewa->lokasi_id)
                ->update(['status' => 'sudah terisi']);
        }
    
        // Update the penyewa status
        $penyewa->update(['status_penyewa' => $request->status_penyewa]);
    
        return redirect()->route('penyewa.index')->with('success', 'Status penyewa berhasil diupdate.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    
    //  public function destroy($id)
    //  {
    //      // Find the Penyewa record by ID
    //      $penyewa = Penyewa::findOrFail($id);
     
    //      // Get the related Kamar record
    //      $kamar = $penyewa->kamar;
     
    //      // Delete the Penyewa record
    //      $penyewa->delete();
     
    //      // Check if the Kamar record exists
    //      if ($kamar) {
    //          // Update the Kamar status to "belum terisi" if it's not already "sudah terisi"
    //          if ($kamar->status !== 'sudah terisi') {
    //              $kamar->update(['status' => 'belum terisi']);
    //          }
    //      }
     
    //      // Redirect to the index page or wherever you want
    //      return redirect()->route('penyewa.index')->with('success_delete', 'Data penyewa berhasil dihapus.');
    //  }

     
     
    
}
