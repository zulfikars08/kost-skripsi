<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penyewa;
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
            'nama_investor' => 'required|string',
            'harga' => 'required',
            'keterangan' => 'required',
            'fasilitas' => 'required',
            'status' => 'required|in:belum terisi,sudah terisi',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
        ], [
            'no_kamar.required' => 'Nomor kamar wajib di isi',
            'harga.required' => 'Harga wajib di isi',
            'keterangan.required' => 'Keterangan wajib di isi',
            'fasilitas.required' => 'Fasilitas wajib di isi',
            'status.required' => 'Status wajib di isi',
            'status.in' => 'Status harus salah satu dari "belum terisi" atau "sudah terisi"',
            'lokasi_id.required' => 'Lokasi kos wajib dipilih',
            'lokasi_id.exists' => 'Lokasi kos yang dipilih tidak valid',
        ]);
    
        $data = [
            'nama_investor' => $request->nama_investor,
            'no_kamar' => $request->no_kamar,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'fasilitas' => $request->fasilitas,
            'status' => $request->status,
            'lokasi_id' => $request->lokasi_id,
        ];
    
        // Create a new Kamar record
        $kamar = Kamar::create($data);
    
        // Automatically create an Investor record
    //     $totalPintu = $kamar = Kamar::where('no_kamar', $request->input('no_kamar'))
    //     ->where('nama_investor', $kamar->nama_investor)
    //     ->where('lokasi_id', $kamar->lokasi_id)
    //     ->firstOrFail();

    // // Find the LokasiKos based on the 'lokasi_id'
    // $lokasiKos = LokasiKos::find($request->lokasi_id);

    // if ($kamar) {
    //     // Create an Investor record with the calculated 'jumlah_pintu'
    //     Investor::create([
    //         'nama' => $request->nama_investor,
    //         'no_kamar' => $request->no_kamar,
    //         'nama_kos' => $lokasiKos->nama_kos,
    //         'kamar_id' => $kamar->id,
    //         'lokasi_id' => $request->lokasi_id,
    //         'jumlah_pintu' => $totalPintu,
    //     ]);
    // } else {
    //     // Handle the case when the 'Kamar' record is not created.
    // }
    
        $page = $request->input('page', 1);
        return redirect()->route('kamar.index', ['page' => $page])->with('success_add', 'Berhasil menambahkan data kamar dan investor');
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
            'status' => 'required|in:belum terisi,sudah terisi',
        ], [
            'harga.required' => 'Harga wajib di isi',
            'keterangan.required' => 'Keterangan wajib di isi',
            'fasilitas.required' => 'Fasilitas wajib di isi',
            'status.required' => 'Status wajib di isi',
            'status.in' => 'Status harus salah satu dari "belum terisi" atau "sudah terisi"',
        ]);
    
        // Check if the status is "belum terisi"
        if ($request->status === 'belum terisi') {
            // Find the related Penyewa record with the same 'no_kamar' and 'lokasi_id'
            $kamar = Kamar::findOrFail($id);
            $lokasiId = $kamar->lokasi_id;
            $noKamar = $kamar->no_kamar;
            
            $penyewa = Penyewa::where('no_kamar', $noKamar)
                ->where('lokasi_id', $lokasiId)
                ->first();
    
            if ($penyewa) {
                // Delete the related Penyewa record
                $penyewa->delete();
            }
        }
    
        $data = [
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'fasilitas' => $request->fasilitas,
            'status' => $request->status,
        ];
    
        Kamar::where('id', $id)->update($data);
    
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
