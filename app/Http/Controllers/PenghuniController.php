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
         // Retrieve all Penyewa records from the database
         $penyewas = Penyewa::paginate(5); // You can adjust the number of records per page
     
         // If a search keyword is provided, filter the results
         if ($request->has('katakunci')) {
             $katakunci = $request->input('katakunci');
             $penyewas = Penyewa::where('nama', 'like', '%' . $katakunci . '%')
                 ->paginate(5); // You can adjust the number of records per page for search results
         }
     
         $lokasiKos = LokasiKos::all();
     
         // Load the view and pass the data to it
         return view('penyewa.index', compact('penyewas', 'lokasiKos'));
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
        $penyewa_id = Penyewa::all('penyewa_id');
        dd($penyewa_id);
        return view('penghuni.create', compact('penyewa_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  

     public function store(Request $request)
     {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'tanggal_lahir' => 'date',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'required|string',
            'pekerjaan' => 'string|nullable',
            'perusahaan' => 'string|nullable',
            'martial_status' => 'required|string',
        ]);
        // Simpan data ke database
        $penghuni = new Penghuni;
        $penghuni->penyewa_id = $request->route('id');
        $penghuni->nama = $validatedData['nama'];
        $penghuni->tanggal_lahir = $validatedData['tanggal_lahir'];
        $penghuni->jenis_kelamin = $validatedData['jenis_kelamin'];
        $penghuni->no_hp = $validatedData['no_hp'];
        $penghuni->pekerjaan = $validatedData['pekerjaan'];
        $penghuni->perusahaan = $validatedData['perusahaan'];
        $penghuni->martial_status = $validatedData['martial_status'];
        $penghuni->save();
     
         // Create the Penghuni record with the validated data
        //  Penghuni::create($request->all());
     
         return redirect()->route('penyewa.penghuni.index', ['id' => $request->route('id')])->with('success', 'Penghuni added successfully.');
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
