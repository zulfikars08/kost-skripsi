<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Pengungsi;
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
        $katakunci = $request->input('katakunci');
        $data = Penghuni::when($katakunci, function ($query) use ($katakunci) {
            $query->where('nama', 'like', "%$katakunci%");
        }) // Eager load the kamars relationship
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('penghuni.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('penghuni.create');
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
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:laki_laki,perempuan',
            'no_hp' => 'required|string',
            'pekerjaan' => 'nullable|string',
            'perusahaan' => 'nullable|string',
            'martial_status' => 'required|string|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            // 'penyewa_id' => 'penyewa,id',

            // 'no_kamar' => 'required|string',
            // 'harga' => 'required',
            // 'keterangan' => 'required',
            // 'fasilitas' => 'required',
            // 'status' => 'required|in:belum terisi,sudah terisi', 
            // 'lokasi_id' => 'required|exists:lokasi_kos,id', 
        ], [
            'nama.required' => 'Nama Penghuni wajib di isi',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib di isi',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih',
            'no_hp.required' => 'No Handphone wajib di isi',
            'martial_status.required' => 'Martial Status wajib dipilih'
            // 'no_kamar.required' => 'Nomor kamar wajib di isi',
            // 'harga.required' => 'Harga wajib di isi',
            // 'keterangan.required' => 'Keterangan wajib di isi',
            // 'fasilitas.required' => 'Fasilitas wajib di isi',
            // 'status.required' => 'Status wajib di isi',
            // 'status.in' => 'Status harus salah satu dari "belum terisi" atau "sudah terisi"',
            // 'lokasi_id.required' => 'Lokasi kos wajib dipilih',
            // 'lokasi_id.exists' => 'Lokasi kos yang dipilih tidak valid',
        ]);
    
        $data = [
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
            'perusahaan' => $request->perusahaan,
            'martial_status' => $request->martial_status,
            'penyewa_id' => $penyewa->id,
            
        ];



        Penghuni::create($data);
        $Penghuni = Penghuni::create($data);
        dd($Penghuni);
        
        $page = $request->input('page', 1); // Get the current page or default to 1
        return redirect()->route('penyewa.penghuni.index', ['page' => $page])->with('success_add', 'Berhasil menambahkan data penghuni');
  
    
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
