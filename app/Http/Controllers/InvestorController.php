<?php

namespace App\Http\Controllers;

use App\Exports\InvestorExport;
use App\Models\Investor;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\TanggalInvestor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InvestorController extends Controller
{
    //
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $lokasi_id = $request->input('lokasi_id'); // Updated to match the input field name
        $nama = $request->input('nama');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT);
            $monthName = date("F", mktime(0, 0, 0, $i, 1));
            $months[$monthValue] = $monthName;
        }

        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        // Fetch necessary data from the database
        $lokasiKos = LokasiKos::all();
        $laporanKeuangan = LaporanKeuangan::all();
        $tanggalInvestor = TanggalInvestor::all();
        $uniqueNamaKos = Investor::select('nama_kos')
            ->distinct()
            ->pluck('nama_kos');

        $investors = collect();

        foreach ($uniqueNamaKos as $namaKos) {
            $investor = Investor::where('nama_kos', $namaKos)
                ->get();
            $investors = $investors->concat($investor);
        }
        $searchTerm = $request->input('nama');
        // Start a new query to filter the data
        $query = Investor::query();

        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
    
        // Apply search term
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        // Get the filtered data
        $investors = $query->get();
        if ($request->ajax()) {
            return view('investor.detail.list', compact('investors', 'months', 'years'));
        }
        // Pagination

        return view('investor.detail.index', compact('investors', 'lokasiKos', 'laporanKeuangan', 'months', 'years', 'tanggalInvestor'));
    }

    // Helper function to generate months array
    public function search(Request $request)
    {
        $searchTerm = $request->input('nama', '');

        // Filter query by search term
        $investors = Investor::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                return
                    $query->where('nama', 'like', "%{$searchTerm}%");
            })
            // Add additional filters if needed
            ->get();

        // Return the partial view with the filtered data
        return view('investor.detail.search', compact('investors'))->render();
    }

    public function create()
    {
        // Retrieve a list of available Lokasi Kos for the dropdown
        $lokasiKos = LokasiKos::all();

        return view('investor.detail.create', compact('lokasiKos'));
    }

    public function store(Request $request)
    {
        // Extract month and year from the input
        $bulan = date('m', strtotime($request->input('bulan')));
        $tahun = date('Y', strtotime($request->input('tahun')));

        // Validate the incoming request
        $request->validate([
            'nama' => 'required|string',
            'jumlah_pintu' => 'required|integer',
            'lokasi_id' => 'required|exists:lokasi_kos,id',
            'bulan' => 'required|date_format:m', // 'm' represents the month format 'mm'
            'tahun' => 'required|date_format:Y',
        ]);

        // Create a new investor record
        $investor = new Investor();
        $investor->nama = $request->input('nama');
        $investor->jumlah_pintu = $request->input('jumlah_pintu');
        $investor->bulan = $request->input('bulan');
        $investor->tahun = $request->input('tahun');
        $investor->lokasi_id = $request->input('lokasi_id');

        // Count the number of investors for the same 'lokasi_id'
        $jumlahInvestor = Investor::where('lokasi_id', $investor->lokasi_id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->count();
        $jumlahInvestor += 1;
        // Assign the total number of investors to the 'jumlah_investor' field
        // $investor->jumlah_investor = $jumlahInvestor;

        // Retrieve LokasiKos based on 'lokasi_id'
        $lokasiKos = LokasiKos::findOrFail($request->input('lokasi_id'));

        // If LokasiKos is found, assign 'nama_kos' to the investor record
        if ($lokasiKos) {
            $investor->nama_kos = $lokasiKos->nama_kos;
        }

        // Find the last "pendapatan_bersih" from "laporan_keuangan"
        $lastPendapatanBersih = LaporanKeuangan::where('nama_kos', $investor->nama_kos)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('tanggal', 'desc') // Order by the 'tanggal' column in descending order
            ->value('pendapatan_bersih');

        // Assign the last "pendapatan_bersih" value to the investor record
        $investor->pendapatan_bersih = $lastPendapatanBersih;

        // Count the number of investors for the same 'lokasi_id', 'bulan', and 'tahun'
        // $jumlahInvestor = Investor::where('lokasi_id', $lokasiKos->id)
        //     ->where('bulan', $request->input('bulan'))
        //     ->where('tahun', $request->input('tahun'))
        //     ->count();

        // Update or create the 'jumlah_investor' field in the existing TanggalInvestor record
        TanggalInvestor::updateOrCreate(
            [
                'nama_kos' => $lokasiKos->nama_kos,
                'bulan' => $request->input('bulan'),
                'tahun' => $request->input('tahun'),
            ],
            [
                'lokasi_id' => $lokasiKos->id,
                'jumlah_investor' => $jumlahInvestor,
            ]
        );

        // Save the investor record
        if ($investor->save()) {
            // Redirect with success message to a dynamic route
            return redirect()->route('investor.detail.index', [
                'lokasi_id' => $investor->lokasi_id,
                'bulan' => $investor->bulan,
                'tahun' => $investor->tahun,
            ])->with('success_add', 'Berhasil menambahkan data');
        } else {
            // Redirect with an error message
            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }
    }




    // public function show($lokasi_id, $bulan, $tahun)
    // {
    //     // Fetch the data you need for the view
    //     $investors = Investor::where('lokasi_id', $lokasi_id)
    //         ->where('bulan', $bulan)
    //         ->where('tahun', $tahun)
    //         ->get();

    //     $lokasiKos = LokasiKos::find($lokasi_id);

    //     return view('investor.detail.show', compact('investors', 'lokasiKos', 'bulan', 'tahun'));
    // }

    public function showGenerateFinancialReportView()
    {
        // Fetch the necessary data for populating dropdowns, e.g., list of Kos, months, and years
        $lokasiKos = LokasiKos::all(); // Adjust the model and query as needed
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT); // Format to two digits (e.g., 01, 02, ...)
            $monthName = date("F", mktime(0, 0, 0, $i, 1)); // Get month name from numeric value
            $months[$monthValue] = $monthName;
        }

        // Generate an array of years (e.g., from the current year to 10 years ago)
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return view('investor.export', compact('lokasiKos', 'months', 'years'));
    }

    public function generateFinancialReport(Request $request)
    {
        // Validate the form data
        $request->validate([
            'nama_kos' => 'required',
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric',
        ]);

        // Get the input values
        $lokasiKosId = $request->input('nama_kos');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Get the name of the selected kos (assuming you have a LokasiKos model)
        $namaKos = LokasiKos::find($lokasiKosId)->nama_kos;

        // Get the name of the selected month
        $namaBulan = date("F", mktime(0, 0, 0, $bulan, 10));

        // Fetch the necessary data for the report
        $investors = Investor::when($lokasiKosId, function ($query) use ($lokasiKosId) {
            return $query->where('lokasi_id', $lokasiKosId);
        })
            ->when($bulan, function ($query) use ($bulan) {
                return $query->where('bulan', $bulan);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->where('tahun', $tahun);
            })
            ->get();

        // Create an instance of your export class with dynamic names
        $export = new InvestorExport($investors);

        // Generate and download the Excel file
        return Excel::download($export, 'investor.xlsx');
    }

    public function edit($id)
    {
        $investor = Investor::find($id);
        $lokasiKos = LokasiKos::all(); // Assuming you have this model
        $months = $this->getMonths(); // Add your logic for getting months
        $years = $this->getYears(); // Add your logic for getting years

        return view('investor.detail.edit', compact('investor', 'lokasiKos', 'months', 'years'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jumlah_pintu' => 'required|numeric',
            // 'lokasi_id' => 'required|exists:lokasi_kos,id',
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric',
        ]);

        $investor = Investor::find($id);

        if (!$investor) {
            return redirect()->back()->with('error', 'Investor tidak ditemukan');
        }

        // Update the investor with the new data
        $investor->update([
            'nama' => $request->input('nama'),
            'jumlah_pintu' => $request->input('jumlah_pintu'),
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            // Add other fields as needed
        ]);

        return redirect()->route('investor.detail.index', [
            'lokasi_id' => $investor->lokasi_id,
            'bulan' => $investor->bulan,
            'tahun' => $investor->tahun,
        ])->with('success_add', 'Berhasil menambahkan data');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $investor = Investor::find($id);

            if (!$investor) {
                DB::rollback();
                return redirect()->back()->with('error', 'Investor tidak ditemukan');
            }

            $tanggalInvestor = TanggalInvestor::where('lokasi_id', $investor->lokasi_id)
                ->where('bulan', $investor->bulan)
                ->where('tahun', $investor->tahun)
                ->first();

            if (!$tanggalInvestor) {
                DB::rollback();
                return redirect()->back()->with('error', 'TanggalInvestor tidak ditemukan');
            }

            // Delete the investor
            $investor->delete();

            // Decrement the jumlah_investor in TanggalInvestor by 1
            $tanggalInvestor->decrement('jumlah_investor');

            DB::commit();
            return redirect()->route('investor.detail.index')->with('success_delete', 'Investor berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus investor');
        }
    }
}
