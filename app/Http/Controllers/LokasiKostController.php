<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\LokasiKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class LokasiKostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = LokasiKos::query();
     
         // Cek apakah ada kata kunci pencarian yang diberikan
         if ($request->filled('katakunci')) {
             $katakunci = $request->input('katakunci');
             $query->where('nama_kos', 'like', '%' . $katakunci . '%');
         }
     
         // Paginate hasil query
         $data = $query->paginate(5);
     
         // Cek apakah request adalah AJAX request
         if ($request->ajax()) {
             // Jika iya, kembalikan partial view yang berisi tabel penyewa saja
             return view('lokasi_kos.list', compact('data'))->render(); // Gunakan render() untuk mendapatkan HTML
         }
     

        return view('lokasi_kos.index', compact('data'));
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
    try {
        // Start a database transaction
        DB::beginTransaction();

        // Validate the request data
        $request->validate([
            'nama_kos' => 'required|string|unique:lokasi_kos,nama_kos',
            'alamat_kos' => 'required',
        ], [
            'nama_kos.required' => 'Nama kos wajib di isi',
            'nama_kos.unique' => 'Nama kos sudah digunakan',
            'alamat_kos.required' => 'Alamat wajib di isi',
        ]);

        // Calculate the total number of kamar based on the sum of jumlah_pintu for the specified nama_kos

        // Create a new LokasiKos record
        $data = [
            'lokasi_id' => $request->lokasi_id,
            'nama_kos' => $request->nama_kos,
            'jumlah_kamar' => $request->jumlah_kamar,
            'alamat_kos' => $request->alamat_kos,
        ];

        LokasiKos::create($data);

        // Commit the database transaction
        DB::commit();

        return redirect()->to('lokasi_kos')->with('success_add', 'Berhasil menambahkan data');

    } catch (\Exception $e) {
        // If an exception occurs, roll back the database transaction
        DB::rollBack();

        // Handle the exception, you can log it or show an error message.
        return redirect()->back()->with('error', 'Nama Lokasi Kos sudah digunakan');
    }
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
    //     return redirect()->to('lokasi_kos')->with('success_update', 'berhasil melakukan update data');
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
        return redirect()->to('lokasi_kos')->with('success_delete','Lokasi Kos Berhasil di hapus');
    }
}
