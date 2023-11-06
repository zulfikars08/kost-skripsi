<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Pengungsi;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PenghuniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        sleep(1);
        $penyewaList = Penyewa::all();

        // Define an empty Penyewa instance
        $selectedPenyewa = new Penyewa();
        $penghuni = Penghuni::all();
        $katakunci = $request->input('katakunci');
        $data = Penghuni::when($katakunci, function ($query) use ($katakunci) {
            $query->where('nama', 'like', "%$katakunci%");
        }) // Eager load the kamars relationship
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('penyewa.penghuni.index', compact('data','penghuni','penyewaList', 'selectedPenyewa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    // Retrieve all Penyewa records
    // Replace $penyewaId with the actual Penyewa ID you want to retrieve
    $penyewaList = Penyewa::all();

    // Define an empty Penyewa instance (or you can set a default value if needed)
    $selectedPenyewa = new Penyewa();

    

    return view('penyewa.penghuni.create', compact('penyewaList', 'selectedPenyewa'));
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
             'penyewa_id' => 'required|exists:penyewa,id',
             'nama' => 'required|string',
             'tanggal_lahir' => 'required|date',
             'jenis_kelamin' => 'required|in:laki_laki,perempuan',
             'no_hp' => 'required|string',
             'pekerjaan' => 'nullable|string',
             'perusahaan' => 'nullable|string',
             'martial_status' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
         ]);
     
         // Create the Penghuni record with the validated data
         Penghuni::create($request->all());
     
         return redirect()->route('penyewa.penghuni.index')->with('success', 'Penghuni added successfully.');
     }
     
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // //
        // $penghuni = Penghuni::findOrFail($id);
    
        // return view('lokasi_kos.detail', compact('lokasiKos'));
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
