<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LokasiKos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KamarController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $katakunci = $request->input('katakunci');
        $filter_by_lokasi = $request->input('filter_by_lokasi');
        $filter_by_status = $request->input('filter_by_status');
        
        $filteredKamarData = Kamar::when($katakunci, function ($query) use ($katakunci) {
                $query->where('no_kamar', 'like', "%$katakunci%");
            })
            ->when($filter_by_lokasi, function ($query) use ($filter_by_lokasi) {
                $query->whereHas('lokasiKos', function ($subQuery) use ($filter_by_lokasi) {
                    $subQuery->where('nama_kos', $filter_by_lokasi);
                });
            })
            ->when($filter_by_status, function ($query) use ($filter_by_status) {
                $query->where('status', $filter_by_status);
            })
            ->with('lokasiKos')
            ->paginate(5);
        
    
        $lokasiKosOptions = LokasiKos::all();
        
        return view('kamar.index', compact('filteredKamarData', 'lokasiKosOptions'));
    }
    
    
    

    // ... Other methods in your controller ...


    public function showKamarData() {
        $filteredKamarData = Kamar::all(); // Fetch all kamar data
    
        return view('kamar.index', compact('kamarData'));
    }





    // Other controller methods such as create, store, edit, update, and destroy...

    
    // Show the form for creating a new resource.
    public function create()
    {
        $lokasiKosOptions = LokasiKos::all();
        return view('kamar.create', compact('lokasiKosOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kamar' => 'required|string',
            'harga' => 'required',
            'keterangan' => 'required',
            'fasilitas' => 'required',
            'status' => 'required|in:belum terisi,sudah terisi', // Ensure the selected status is valid
            'kost_id' => 'required|exists:lokasi_kos,id', // Ensure the selected lokasiKos exists
        ], [
            'no_kamar.required' => 'Nomor kamar wajib di isi',
            'harga.required' => 'Harga wajib di isi',
            'keterangan.required' => 'Keterangan wajib di isi',
            'fasilitas.required' => 'Fasilitas wajib di isi',
            'status.required' => 'Status wajib di isi',
            'status.in' => 'Status harus salah satu dari "belum terisi" atau "sudah terisi"',
            'kost_id.required' => 'Lokasi kos wajib dipilih',
            'kost_id.exists' => 'Lokasi kos yang dipilih tidak valid',
        ]);
    
        $data = [
            'no_kamar' => $request->no_kamar,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'fasilitas' => $request->fasilitas,
            'status' => $request->status,
            'kost_id' => $request->kost_id,
        ];


    //  \Illuminate\Support\Facades\Cache::forget('kamar.index');

    $page = $request->input('page', 1); // Get the current page or default to 1
    return redirect()->route('kamar.index', ['page' => $page])->with('success_add', 'Berhasil menambahkan data kamar');
    }
    

    // ... Other methods ...


    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $data = Kamar::findOrFail($id);
        return view('kamar.edit', compact('data'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required',
            'keterangan' => 'required',
            'fasilitas' => 'required',
            'status' => 'required|in:belum terisi,sudah terisi', // Ensure the selected status is valid
        ], [
            'harga.required' => 'Harga wajib di isi',
            'keterangan.required' => 'Keterangan wajib di isi',
            'fasilitas.required' => 'Fasilitas wajib di isi',
            'status.required' => 'Status wajib di isi',
            'status.in' => 'Status harus salah satu dari "belum terisi" atau "sudah terisi"',
        ]);
    
        $data = [
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'fasilitas' => $request->fasilitas,
            'status' => $request->status,
        ];
    
        Kamar::where('id', $id)->update($data); // Update the kamar record
        return redirect()->route('kamar.index')->with('success_update', 'Berhasil melakukan update data kamar');
    }
    
    
    // routes/web.php


    // Remove the specified resource from storage.
    public function destroy($id)
    {
        Kamar::where('id', $id)->delete();
        return redirect()->route('kamar.index')->with('success_delete', 'Berhasil melakukan delete');
    }
}
