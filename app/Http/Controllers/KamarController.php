<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penyewa;
use App\Models\TipeKamar;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KamarController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        // Retrieve input data from the request
        $namaKos = $request->input('nama_kos');
        $tipe_kamar = $request->input('tipe_kamar_id'); // Update the input name here
        $status = $request->input('status');
    
        // Query to filter Kamar data based on user inputs
        $filteredKamarData = Kamar::when($namaKos, function ($query) use ($namaKos) {
                $query->whereHas('lokasiKos', function ($subQuery) use ($namaKos) {
                    $subQuery->where('nama_kos', $namaKos);
                });
            })
            ->when($tipe_kamar, function ($query) use ($tipe_kamar) {
                $query->where('tipe_kamar', $tipe_kamar);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->with('lokasiKos')
            ->paginate(5);
    
        $lokasiKosOptions = LokasiKos::all();
        $tipeKamarOptions = TipeKamar::all();
        $fasilitasOptions = Fasilitas::all();
        $kamars = Kamar::all();
    
        return view('kamar.index', compact('filteredKamarData', 'lokasiKosOptions', 'kamars','fasilitasOptions','tipeKamarOptions'));
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
        $fasilitasOptions = Fasilitas::all();
        return view('kamar.create', compact('lokasiKos','fasilitasOptions'));
    }

   
    public function store(Request $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();
    
            // Check if the combination of no_kamar and lokasi_id already exists
            $existingKamar = Kamar::where('no_kamar', $request->no_kamar)
                ->where('lokasi_id', $request->lokasi_id)
                ->first();
    
            if ($existingKamar) {
                return redirect()->back()->with('error', 'Nomor kamar sudah digunakan untuk lokasi kos ini.');
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
                'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
                'fasilitas' => 'required|array',
                'fasilitas.*' => 'exists:fasilitas,id',
                'status' => 'required|in:Belum Terisi,Sudah Terisi',
                'lokasi_id' => 'required|exists:lokasi_kos,id',
            ], [
                // Custom error messages...
                'no_kamar.required' => 'Nomor kamar wajib di isi',
                'no_kamar.unique' => 'Nomor kamar sudah digunakan untuk lokasi kos ini',
                'harga.required' => 'Harga wajib di isi',
                'tipe_kamar_id.required' => 'Tipe kamar wajib di isi',
                'tipe_kamar_id.exists' => 'Tipe kamar yang dipilih tidak valid',
                'fasilitas.required' => 'Fasilitas wajib di isi',
                'status.required' => 'Status wajib di isi',
                'status.in' => 'Status harus salah satu dari "Belum Terisi" atau "Sudah Terisi"',
                'lokasi_id.required' => 'Lokasi kos wajib dipilih',
                'lokasi_id.exists' => 'Lokasi kos yang dipilih tidak valid',
            ]);
    
            // Use the validated data
            $data = [
                'no_kamar' => $request->no_kamar,
                'harga' => $request->harga,
                'status' => $request->status,
                'lokasi_id' => $request->lokasi_id,
                'tipe_kamar' => TipeKamar::find($request->tipe_kamar_id)->tipe_kamar,
                'tipe_kamar_id' => $request->tipe_kamar_id,
            ];
    
            // Create a new Kamar record
            $kamar = Kamar::create($data);
    
            // Attach selected fasilitas to the Kamar
            $kamar->fasilitas()->attach($request->input('fasilitas'));
    
            // Commit the database transaction
            DB::commit();
    
            $page = $request->input('page', 1);
            return redirect()->route('kamar.index', ['page' => $page])->with('success_add', 'Berhasil menambahkan data kamar');
    
        } catch (\Exception $e) {
            // If an exception occurs, roll back the database transaction
            DB::rollBack();
    
            // Handle the exception, you can log it or show an error message.
            return redirect()->back()->with('error', 'Data yang diberikan tidak valid' );
        }
    
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
        try {
            // Begin a database transaction
            DB::beginTransaction();
    
            $request->validate([
                'harga' => 'required',
                'tipe_kamar_id' => 'required|exists:tipe_kamar,id',
                'fasilitas' => 'required|array',
                'fasilitas.*' => 'exists:fasilitas,id',
                'status' => 'required|in:Belum Terisi,Sudah Terisi',
                'lokasi_id' => 'required|exists:lokasi_kos,id',
            ], [
                // Custom error messages...
                'harga.required' => 'Harga wajib di isi',
                'tipe_kamar_id.required' => 'Tipe kamar wajib di isi',
                'tipe_kamar_id.exists' => 'Tipe kamar yang dipilih tidak valid',
                'fasilitas.required' => 'Fasilitas wajib di isi',
                'status.required' => 'Status wajib di isi',
                'status.in' => 'Status harus salah satu dari "Belum Terisi" atau "Sudah Terisi"',
                'lokasi_id.required' => 'Lokasi kos wajib dipilih',
                'lokasi_id.exists' => 'Lokasi kos yang dipilih tidak valid',
            ]);
            // Check for updates on the harga field
            $harga = $request->filled('harga') ? intval(str_replace(',', '', $request->harga)) : null;
    
            $data = [
                'harga' => $harga,
                'status' => $request->input('status'),
                'lokasi_id' => $request->lokasi_id,
                'tipe_kamar_id' => $request->tipe_kamar_id,
            ];
    
            // Update the Kamar record
            Kamar::where('id', $id)->update($data);
    
            // Sync the fasilitas relationship
            Kamar::find($id)->fasilitas()->sync($request->input('fasilitas'));
    
            // Commit the database transaction
            DB::commit();
    
            return redirect()->route('kamar.index')->with('success_update', 'Berhasil melakukan update data kamar');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an exception
            DB::rollBack();
    
            // Handle the exception, you can log it or show an error message.
            return redirect()->back()->with('error', 'Data yang diberikan tidak valid');
        }
    }
    
    
    
    
    // routes/web.php

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        Kamar::where('id', $id)->delete();
        return redirect()->route('kamar.index')->with('success_delete', 'Berhasil melakukan delete Kamar');
    }
}
