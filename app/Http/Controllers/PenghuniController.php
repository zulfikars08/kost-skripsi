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
            'jenis_kelamin' => 'required', // Sesuaikan dengan aturan validasi yang sesuai
            'tanggal_lahir' => 'required',
            'no_hp' => 'required', // Sesuaikan dengan aturan validasi yang sesuai
            'pekerjaan' => 'required', // Sesuaikan dengan aturan validasi yang sesuai
            'perusahaan' => 'required', // Sesuaikan dengan aturan validasi yang sesuai
            'status' => 'required', // Sesuaikan dengan aturan validasi yang sesuai
        ],
        [
            'nama.required' => 'Nama wajib di isi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib di isi',
            'tanggal_lahir.required' => 'tanggal lahir wajib di isi',
            'no_hp.required' => 'no hp wajib di isi',
            'pekerjaan.required' => 'pekerjaan wajib di isi',
            'perusahaan.required' => 'perusahaan wajib di isi',
            'status.required' => 'status wajib di isi'
            // ... tambahkan pesan validasi lainnya ...
        ]);
    
        // Simpan data ke dalam model Penghuni
        $data = [
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
            'perusahaan' => $request->perusahaan,
            'status' => $request->status,
        ];

        if ($request->pekerjaan === 'Lainnya') {
            $data['pekerjaan'] = $request->pekerjaan_lainnya;
        }

        Penghuni::create($data);
    
        return redirect()->route('lokasi_kos.index')->with('success_add', 'Berhasil menambahkan data');
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
