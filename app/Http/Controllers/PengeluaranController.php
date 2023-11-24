<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\Pengeluaran;
use App\Models\TanggalInvestor;
use App\Models\TanggalLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kamars = Kamar::all();
        $lokasiKos = LokasiKos::all();
        $namaKos = $request->input('nama_kos');
        $bulan = $request->input('bulan');
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
        $query = Pengeluaran::query();

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
    
        $pengeluaran = $request->ajax() ? $query->get() : $query->paginate(10);
    
        return view('pengeluaran.index', compact('pengeluaran', 'lokasiKos', 'months', 'years', 'kamars'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasiKos = LokasiKos::all(); // Fetch the data for $lokasiKos

        return view('pengeluaran.create', compact('lokasiKos'));
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
    
            $request->validate([
                'kamar_id' => 'required|exists:kamar,id',
                'lokasi_id' => 'required|exists:lokasi_kos,id',
                'tanggal' => 'required|date',
                'tipe_pembayaran' => 'required|in:tunai,non-tunai',
                'bukti_pembayaran' => 'required_if:tipe_pembayaran,non-tunai|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'jumlah' => 'required|numeric',
                'keterangan' => 'required|string',
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
                'keterangan.required' => 'Keterangan wajib di isi',
                'keterangan.string' => 'Keterangan harus berupa teks',
            ]);
    
            // Create a new Pengeluaran instance
            $pengeluaran = new Pengeluaran([
                'kamar_id' => $request->input('kamar_id'),
                'lokasi_id' => $request->input('lokasi_id'),
                'tanggal' => $request->input('tanggal'),
                'tipe_pembayaran' => $request->input('tipe_pembayaran'),
                'bukti_pembayaran' => $request->input('bukti_pembayaran'),
                'jumlah' => $request->input('jumlah'),
                'keterangan' => $request->input('keterangan'),
            ]);
    
            $nama_kos = $pengeluaran->lokasiKos->nama_kos;
    
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Appending timestamp to ensure uniqueness
                $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
                $pengeluaran->bukti_pembayaran = $filePath; // Use -> instead of array notation
            } elseif ($request->input('tipe_pembayaran') === 'tunai') {
                $pengeluaran->bukti_pembayaran = 'Cash Payment'; // Use -> instead of array notation
            }
    
            // Save the Pengeluaran
            $pengeluaran->save();
    
            $tanggal = $pengeluaran->tanggal;
            $bulan = date('m', strtotime($tanggal));
            $tahun = date('Y', strtotime($tanggal));
    
            // Set the attributes for the new LaporanKeuangan instance
    
            $laporanKeuanganAttributes = [
                'tanggal' => $tanggal,
                'kamar_id' => $pengeluaran->kamar_id,
                'lokasi_id' => $pengeluaran->lokasi_id,
                'pengeluaran_id' => $pengeluaran->id,
                'kode_pengeluaran' => $pengeluaran->kode_pengeluaran,
                'jenis' => 'pengeluaran',
                'nama_kos' => $nama_kos,
                'tipe_pembayaran' => $pengeluaran->tipe_pembayaran,
                'bukti_pembayaran' => $pengeluaran->bukti_pembayaran,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'pengeluaran' => $pengeluaran->jumlah,
                'keterangan' => $pengeluaran->keterangan,
            ];
            // Create a new LaporanKeuangan instance
            $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);
            $tanggalLaporanAtributes = [
                'nama_kos' => $nama_kos,
                'kamar_id' => $pengeluaran->kamar_id,
                'lokasi_id' => $pengeluaran->lokasi_id, // Assign the penyewa_id
                // Set the default value or adjust as needed
                'bulan' => $bulan,
                'tahun' => $tahun,
               // Set to '-' for string columns
                'tanggal' => $pengeluaran->tanggal,
            ];
    
            $tanggalInvestorAttributes = [
                'nama_kos' => $nama_kos,
                'lokasi_id' => $pengeluaran->lokasi_id, // Assign the penyewa_id
                // Set the default value or adjust as needed
                'bulan' => $bulan,
                'tahun' => $tahun,
               // Set to '-' for string columns
                'tanggal' => $pengeluaran->tanggal,
            ];
    
            // Create a new LaporanKeuangan instance
            $laporanKeuangan = new LaporanKeuangan($laporanKeuanganAttributes);
            $existingLaporan = TanggalLaporan::where('nama_kos', $nama_kos)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
    
            $existingInvestor = TanggalInvestor::where('nama_kos', $nama_kos)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();
    
            if ($existingLaporan) {
                // Update existing entry
                $existingLaporan->update($tanggalLaporanAtributes);
            } else {
                // Create a new entry
                $tanggalLaporan = new TanggalLaporan($tanggalLaporanAtributes);
                $tanggalLaporan->save();
            }
    
            if ($existingInvestor) {
                // Update existing entry
                $existingInvestor->update($tanggalInvestorAttributes);
            } else {
                // Create a new entry
                $tanggalInvestor = new TanggalInvestor($tanggalInvestorAttributes);
                $tanggalInvestor->save();
            }
            // Save the new LaporanKeuangan instance
            $laporanKeuangan->save();
    
            // Commit the database transaction
            DB::commit();
    
            return redirect()->route('pengeluaran.index')->with('success_add', 'Data pengeluaran berhasil ditambahkan');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an exception
            DB::rollBack();
    
            // Log or handle the exception as needed
            return redirect()->back()->with('error', 'Gagal menambahkan data pengeluaran');
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
        $expenditure = Pengeluaran::findOrFail($id); // Assuming you're using Eloquent

        return view('pengeluaran.detail', compact('expenditure'));
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
        try {
            // Find the Pemasukan item by ID
            $pengeluaran = Pengeluaran::findOrFail($id);

            // Implement your logic for deleting the item (e.g., database deletion)
            $pengeluaran->delete();

            // Optionally, you can send a success message back
            return redirect()->route('pemasukan.index')->with('success_delete', 'Data pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during deletion
            // Log the error or return an error response
            return response()->json(['error' => 'Data pengeluaran gagal dihapus'], 500);
        }
    }
}
