<?php

namespace App\Http\Controllers;

use App\Models\LokasiKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LokasiKostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        sleep(1);
        $katakunci = $request->input('katakunci');
        $data = LokasiKos::with('kamars')->when($katakunci, function ($query) use ($katakunci) {
            return $query->where('nama_kos', 'like', "%$katakunci%");
        }) // Eager load the kamars relationship
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('lokasi_kos.index', compact('data'));
    }

    public function lokasi(Request $request)
{
    sleep(1);
    $katakunci = $request->input('katakunci');
    
    $lokasiKosData = LokasiKos::with('kamars')
        ->when($katakunci, function ($query) use ($katakunci) {
            return $query->where('nama_kos', 'like', "%$katakunci%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    return view('tanggal-transaksi.lokasi', compact('lokasiKosData'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        return view('lokasi_kos.create');
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
        Session::flash('nama_kos',$request->nama_kos);
        Session::flash('jumlah_kamar',$request->jumlah_kamar);
        Session::flash('alamat_kos',$request->alamat_kos);
        $request->validate([
            'nama_kos' => 'required|string|unique:lokasi_kos,nama_kos',
            'jumlah_kamar' => 'required',
            'alamat_kos' => 'required',
        ],
        [
            'nama_kos.required' => 'nama kos wajib di isi',
            'nama_kos.unique' => 'nama kos sudah digunakan',
            'jumlah_kamar.required' => 'jumlah kamar wajib di isi',
            'alamat_kos.required' => 'alamat wajib di isi',
        ]     
    );
        $data = [
            'lokasi_id' => $request->lokasi_id,
            'nama_kos' => $request->nama_kos,
            'jumlah_kamar' => $request->jumlah_kamar,
            'alamat_kos' => $request->alamat_kos,
          
        ];
        LokasiKos::create($data);
        return redirect()->to('lokasi_kos')->with('success_add', 'berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function detail($id)
    // {
    //     $lokasiKos = LokasiKos::with('kamar')->findOrFail($id);
    //     return view('lokasi_kos.detail', compact('lokasiKos'));
    // }
    public function show($id)
    {
        $lokasiKos = LokasiKos::findOrFail($id);
    
        return view('lokasi_kos.detail', compact('lokasiKos'));
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
        // $data = LokasiKos::where('id',$id)->first();
        // return view('lokasi_kos.edit')->with('data',$data);
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
    //     $request->validate([
    //         'jumlah_kamar' => 'required',
    //         'alamat_kos' => 'required',
    //     ],
    //     [
    //         'jumlah_kamar.required' => 'jumlah kamar wajib di isi',
    //         'alamat_kos.required' => 'alamat wajib di isi',
    //     ]     
    // );
    //     $data = [
    //         'jumlah_kamar' => $request->jumlah_kamar,
    //         'alamat_kos' => $request->alamat_kos,
          
    //     ];
    //     LokasiKos::where('id',$id)->update($data);
    //     return redirect()->to('lokasi_kos')->with('success', 'berhasil melakukan update data');
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
        LokasiKos::where('id', $id)->delete();
        return redirect()->to('lokasi_kos')->with('success_delete','berhasil melakukan delete');
    }
}
