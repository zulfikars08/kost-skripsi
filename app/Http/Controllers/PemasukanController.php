<?php

namespace App\Http\Controllers;

use App\Events\PemasukanCreated;
use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\TanggalInvestor;
use App\Models\TanggalLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $kamars = Kamar::all();
        $lokasiKos = LokasiKos::all();
        $bulan = $request->input('bulan');
        $namaKos = $request->input('nama_kos');
        $tahun = $request->input('tahun');
        $tipe_pembayaran = $request->input('tipe_pembayaran');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
            // ... (your month data creation)
        }
        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        // Retrieve expenditures and apply any search filter if provided
        $query = Pemasukan::query();

        $query->when($namaKos, function ($q) use ($namaKos) {
            return $q->whereHas('lokasiKos', function ($subQuery) use ($namaKos) {
                $subQuery->where('nama_kos', $namaKos);
            });
        })
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($q) use ($tahun) {
                return $q->whereYear('tanggal', $tahun);
            })
            ->when($tipe_pembayaran, function ($q) use ($tipe_pembayaran) {
                return $q->where('tipe_pembayaran', $tipe_pembayaran);
            })
            ->with('lokasiKos');
    
        // Check if a search query is provided
        if ($request->has('katakunci')) {
            $keyword = $request->input('katakunci');
            $query->where('nama_kos', 'like', '%' . $keyword . '%')
                ->orWhere('bulan', 'like', '%' . $keyword . '%')
                ->orWhere('tahun', 'like', '%' . $keyword . '%');
        }
    
        $pemasukan = $request->ajax() ? $query->get() : $query->paginate(5);
    
        return view('pemasukan.index', compact('pemasukan', 'lokasiKos', 'months', 'years', 'kamars'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $lokasiKos = LokasiKos::all(); // Fetch the data for $lokasiKos

        return view('pemasukan.create', compact('lokasiKos'));
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
            // Begin a database transaction
            DB::beginTransaction();

            // Validate the request data
            $request->validate([
                'kamar_id' => 'required|exists:kamar,id',
                'lokasi_id' => 'required|exists:lokasi_kos,id',
                'tanggal' => 'required|date',
                'tipe_pembayaran' => 'required|in:tunai,non-tunai',
                'bukti_pembayaran' => 'required_if:tipe_pembayaran,non-tunai|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'jumlah' =>  ['required', 'regex:/^\d+(\,\d{1,3})*$/'],
                'tanggal_pembayaran_awal' => 'nullable|date',
                'tanggal_pembayaran_akhir' => 'nullable|date',
                'status_pembayaran' => 'nullable|in:lunas,cicil,belum-lunas',
                'keterangan' => 'nullable|string',
            ], [
                'kamar_id.required' => 'Nomor kamar wajib di isi',
                'kamar_id.exists' => 'Nomor kamar tidak valid',
                'lokasi_id.required' => 'Lokasi kos wajib dipilih',
                'lokasi_id.exists' => 'Lokasi kos yang dipilih tidak valid',
                'tanggal.required' => 'Tanggal wajib di isi',
                'tanggal.date' => 'Format tanggal tidak valid',
                'tipe_pembayaran.required' => 'Tipe pembayaran wajib di isi',
                'tipe_pembayaran.in' => 'Tipe pembayaran harus salah satu dari "tunai" atau "non-tunai"',
                'bukti_pembayaran.required_if' => 'Bukti pembayaran wajib di isi jika tipe pembayaran non-tunai',
                'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar',
                'bukti_pembayaran.mimes' => 'Format bukti pembayaran tidak valid. Gunakan format jpeg, png, jpg, gif, atau svg',
                'bukti_pembayaran.max' => 'Ukuran bukti pembayaran tidak boleh melebihi 2048 kilobita',
                'jumlah.required' => 'Jumlah wajib di isi',
                'jumlah.numeric' => 'Jumlah harus berupa angka',
                // Add other custom error messages as needed
            ]);

            // Create a new Pemasukan instance
            $pemasukan = new Pemasukan([
                'kamar_id' => $request->input('kamar_id'),
                'lokasi_id' => $request->input('lokasi_id'),
                'tanggal' => $request->input('tanggal'),
                'tipe_pembayaran' => $request->input('tipe_pembayaran'),
                'bukti_pembayaran' => $request->input('bukti_pembayaran'),
                'jumlah' => str_replace(',', '', $request->input('jumlah')),
                'tanggal_pembayaran_awal' => $request->input('tanggal_pembayaran_awal'),
                'tanggal_pembayaran_akhir' => $request->input('tanggal_pembayaran_akhir'),
                'status_pembayaran' => $request->input('status_pembayaran'),
                'keterangan' => $request->input('keterangan'),
            ]);

            $nama_kos = $pemasukan->lokasiKos->nama_kos;

            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Appending timestamp to ensure uniqueness
                $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
                $pemasukan->bukti_pembayaran = $filePath; // Use -> instead of array notation
            } elseif ($request->input('tipe_pembayaran') === 'tunai') {
                $pemasukan->bukti_pembayaran = 'Cash Payment'; // Use -> instead of array notation
            }
            $existingPemasukan = Pemasukan::where('kamar_id', $request->input('kamar_id'))
            ->where('lokasi_id', $request->input('lokasi_id'))
            ->where('tanggal', $request->input('tanggal'))
            ->where('jumlah', $request->input('jumlah'))
            ->first();

        if ($existingPemasukan) {
            // If a record already exists, return with an error message
            return redirect()->back()->with('error', 'Data pemasukan sudah ada.');
        }
            // Save the Pemasukan
            $pemasukan->save();
            event(new PemasukanCreated($pemasukan));
            // $tanggal = $pemasukan->tanggal;
            // $bulan = date('m', strtotime($tanggal));
            // $tahun = date('Y', strtotime($tanggal));

            // $laporanKeuanganAttributes = [
            //     'tanggal' => $tanggal,
            //     'kamar_id' => $pemasukan->kamar_id,
            //     'lokasi_id' => $pemasukan->lokasi_id,
            //     'pemasukan_id' => $pemasukan->id,
            //     'jenis' => 'pemasukan',
            //     'nama_kos' => $nama_kos,
            //     'kode_pemasukan' => $pemasukan->kode_pemasukan,
            //     'tipe_pembayaran' => $pemasukan->tipe_pembayaran,
            //     'bukti_pembayaran' => $pemasukan->bukti_pembayaran,
            //     'bulan' => $bulan,
            //     'tahun' => $tahun,
            //     'pemasukan' => $pemasukan->jumlah,
            //     'keterangan' => $pemasukan->keterangan,
            // ];

            // $tanggalLaporanAtributes = [
            //     'nama_kos' => $nama_kos,
            //     'kamar_id' => $pemasukan->kamar_id,
            //     'lokasi_id' => $pemasukan->lokasi_id, // Assign the penyewa_id
            //     // Set the default value or adjust as needed
            //     'bulan' => $bulan,
            //     'tahun' => $tahun,
            //     // Set to '-' for string columns
            //     'tanggal' => $pemasukan->tanggal,
            // ];

            // $tanggalInvestorAttributes = [
            //     'nama_kos' => $nama_kos,
            //     'lokasi_id' => $pemasukan->lokasi_id, // Assign the penyewa_id
            //     // Set the default value or adjust as needed
            //     'bulan' => $bulan,
            //     'tahun' => $tahun,
            //     // Set to '-' for string columns
            //     'tanggal' => $pemasukan->tanggal,
            // ];

            // // Create a new LaporanKeuangan instance
            // $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);
            // $existingLaporan = TanggalLaporan::where('nama_kos', $nama_kos)
            //     ->where('bulan', $bulan)
            //     ->where('tahun', $tahun)
            //     ->first();

            // $existingInvestor = TanggalInvestor::where('nama_kos', $nama_kos)
            //     ->where('bulan', $bulan)
            //     ->where('tahun', $tahun)
            //     ->first();

            // if ($existingLaporan) {
            //     // Update existing entry
            //     $existingLaporan->update($tanggalLaporanAtributes);
            // } else {
            //     // Create a new entry
            //     $tanggalLaporan = new TanggalLaporan($tanggalLaporanAtributes);
            //     $tanggalLaporan->save();
            // }

            // if ($existingInvestor) {
            //     // Update existing entry
            //     $existingInvestor->update($tanggalInvestorAttributes);
            // } else {
            //     // Create a new entry
            //     $tanggalInvestor = new TanggalInvestor($tanggalInvestorAttributes);
            //     $tanggalInvestor->save();
            // }
            // // Save the new LaporanKeuangan instance
            // $laporanKeuangan->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('pemasukan.index')->with('success_add', 'Data pemasukan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an exception
            DB::rollBack();

            // Log or handle the exception as needed
            return redirect()->back()->with('error', 'Gagal menambahkan data pemasukan');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pemasukan = Pemasukan::findOrFail($id);
        $lokasiKos = LokasiKos::all();
        $kamars = Kamar::all();

        return view('pemasukan.edit', compact('pemasukan', 'lokasiKos', 'kamars'));
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
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
            'tanggal' => 'required|date',
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
            // Add other validation rules as needed
        ]);

        $pemasukan = Pemasukan::findOrFail($id);
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Appending timestamp to ensure uniqueness
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            // Change the directory name here
            $pemasukan->bukti_pembayaran = $filePath; // Use -> instead of array notation
        } elseif ($request->input('tipe_pembayaran') === 'tunai') {
            $pemasukan->bukti_pembayaran = 'Cash Payment'; // Use -> instead of array notation
        }

        $pemasukan->update([
            'kamar_id' => $request->input('kamar_id'),
            'lokasi_id' => $request->input('lokasi_id'),
            'tanggal' => $request->input('tanggal'),
            'tipe_pembayaran' => $request->input('tipe_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
            // Add other fields as needed
        ]);
        return redirect()->route('pemasukan.index')->with('success_update', 'Data pemasukan berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Find the Pemasukan item by ID
                $pemasukan = Pemasukan::findOrFail($id);
    
                // Delete related Laporan Keuangan entries
                LaporanKeuangan::where('pemasukan_id', $pemasukan->id)->delete();
    
                // Delete the Pemasukan item
                $pemasukan->delete();
            });
    
            // Optionally, you can send a success message back
            return redirect()->route('pemasukan.index')->with('success_delete', 'Data pemasukan berhasil dihapus');
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during deletion
            // Log the error or return an error response
            return response()->json(['error' => 'Data pemasukan gagal dihapus'], 500);
        }
    }
    
}
