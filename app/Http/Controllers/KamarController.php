<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penyewa;
use App\Models\TipeKamar;
use Illuminate\Validation\Rule;

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
        $kamars = Kamar::all();

        return view('kamar.index', compact('filteredKamarData', 'lokasiKosOptions','kamars'));
    }


    // ... Other methods in your controller ...


    public function showKamarData()
    {
        $filteredKamarData = Kamar::all(); // Fetch all kamar data

        return view('kamar.index', compact('kamarData'));
    }


    // Other controller methods such as create, store, edit, update, and destroy...


    // Show the form for creating a new resource.
    public function create()
    {
        $lokasiKos = LokasiKos::all();
        return view('kamar.create', compact('lokasiKos'));
    }

   
    public function store(Request $request)
    {
        // Check if the combination of no_kamar and lokasi_id already exists
        $existingKamar = Kamar::where('no_kamar', $request->no_kamar)
            ->where('lokasi_id', $request->lokasi_id)
            ->first();
    
        if ($existingKamar) {
            return redirect()->back()->with('errorNoKamar', 'Nomor kamar sudah digunakan untuk lokasi kos ini.');
        }
    
        $request->validate([
            'no_kamar' => [
                'required',
                'string',
                Rule::unique('kamar')->where(function ($query) use ($request) {
                    return $query->where('no_kamar', $request->no_kamar)
                        ->where('lokasi_id', $request->lokasi_id);
                }),
            ],
            'harga' => 'required',
            'tipe_kamar' => 'required|in:AC,Non AC',
            'fasilitas' => 'required|array',
            'fasilitas.*' => 'in:AC,Lemari,Kasur,TV',
            'status' => 'required|in:Belum Terisi,Sudah Terisi',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
        ], [
            // Custom error messages...
            'no_kamar.required' => 'Nomor kamar wajib di isi',
            'no_kamar.unique' => 'Nomor kamar sudah digunakan untuk lokasi kos ini',
            'harga.required' => 'Harga wajib di isi',
            'tipe_kamar.required' => 'Tipe kamar wajib di isi',
            'fasilitas.required' => 'Fasilitas wajib di isi',
            'status.required' => 'Status wajib di isi',
            'status.in' => 'Status harus salah satu dari "Belum Terisi" atau "Sudah Terisi"',
            'lokasi_id.required' => 'Lokasi kos wajib dipilih',
            'lokasi_id.exists' => 'Lokasi kos yang dipilih tidak valid',
        ]);
    
        // Convert array to string
        $fasilitas = implode(',', $request->input('fasilitas'));
    
        // Use the validated data
        $data = [
            'no_kamar' => $request->no_kamar,
            'harga' => $request->harga,
            'tipe_kamar' => $request->tipe_kamar,
            'fasilitas' =>  $fasilitas,
            'status' => $request->status,
            'lokasi_id' => $request->lokasi_id,
        ];
    
        // Create a new Kamar record
        $kamar = Kamar::create($data);
        // Create a new TipeKamar record
        TipeKamar::create([
            'kamar_id' => $kamar->id,
            'no_kamar' => $kamar->no_kamar,
            'nama_kos' => LokasiKos::findOrFail($request->input('lokasi_id'))->nama_kos, // Use the value from the data array
            'lokasi_id' => $kamar->lokasi_id,
            'tipe_kamar' => $data['tipe_kamar'],
        ]);
        $page = $request->input('page', 1);
        return redirect()->route('kamar.index', ['page' => $page])->with('success_add', 'Berhasil menambahkan data kamar dan investor');
    }
    

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $kamars = Kamar::findOrFail($id);
        return view('kamar.edit', compact('kamars'));
    }


    // Update the specified resource in storage.
public function update(Request $request, $id)
{
    $request->validate([
        'harga' => 'required',
        'tipe_kamar' => 'required|in:AC,Non AC',
        'fasilitas' => 'required',
        // 'status' => 'required|in:Belum Terisi,Sudah Terisi',
        'lokasi_id' => 'required',
    ], [
        'harga.required' => 'Harga wajib di isi',
        'tipe_kamar.required' => 'Tipe kamar wajib di isi',
        'fasilitas.required' => 'Fasilitas wajib di isi',
        // 'status.required' => 'Status wajib di isi',
        // 'status.in' => 'Status harus salah satu dari "belum terisi" atau "sudah terisi"',
        'lokasi_id.required' => 'Lokasi Kos wajib di isi',
    ]);
    // Check if the status is "belum terisi"
    if ($request->status === 'Belum Terisi') {
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
    // Periksa apakah ada pembaruan pada harga
    $harga = $request->filled('harga') ? intval(str_replace(',', '', $request->harga)) : intval(str_replace(',', '', $request->harga));

    $data = [
        'harga' => $harga,
        'tipe_kamar' => $request->tipe_kamar,
        'fasilitas' => implode(',', $request->fasilitas), // Convert array to comma-separated string
        // 'status' => $request->status,
        'lokasi_id' => $request->lokasi_id,
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
