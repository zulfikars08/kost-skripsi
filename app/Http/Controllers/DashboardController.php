<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Kamar;
use App\Models\LaporanKeuangan;
use App\Models\LokasiKos;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Penghuni;
use App\Models\Penyewa;
use App\Models\Transaksi;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        sleep(1); // Simulating delay for loading
        $totalKamar = Kamar::count();
        $totalLokasiKos = LokasiKos::count();

        $totalKamarSudahTerisi = Kamar::where('status', 'Sudah Terisi')->count();
        $totalKamarBelumTerisi = Kamar::where('status', 'Belum Terisi')->count();
        $totalTransaksi = Transaksi::count();
        $totalPenyewa = Penyewa::count();
        $totalPenyewaAktif = Penyewa::where('status_penyewa', 'aktif')->count();

        // Filter data for the current month
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');
        $selectedNamaKos = $request->input('nama_kos', 'All');
        $selectedBulan = $request->input('bulan', now()->format('m'));
        $selectedTahun = $request->input('tahun', now()->format('Y'));

        // Your existing code here...

        // Retrieve data for the slicers
        $namaKosList = LokasiKos::pluck('nama_kos'); // Assuming LokasiKos has a 'nama_kos' attribute
        $bulanList = range(1, 12);
        $tahunList = range(date('Y') - 10, date('Y'));
        $totalInvestor = Investor::count();
        $totalPemasukan = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->sum('pemasukan');
        $totalPengeluaran = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->sum('pengeluaran');
        $pemasukanData = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->get();
        $pengeluaranData = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->get();

        $pendapatanBersih = $totalPemasukan - $totalPengeluaran;

        $query = LaporanKeuangan::query();

        // Filter by nama kos if provided
        if ($selectedNamaKos && $selectedNamaKos != 'All') {
            $query->whereHas('lokasiKos', function ($query) use ($selectedNamaKos) {
                $query->where('nama_kos', $selectedNamaKos);
            });
        }

        // Filter by bulan if provided
        if ($selectedBulan && $selectedBulan != 'All') {
            $query->whereMonth('tanggal', $selectedBulan);
        }

        // Filter by tahun if provided
        if ($selectedTahun && $selectedTahun != 'All') {
            $query->whereYear('tanggal', $selectedTahun);
        }


        // Get the filtered results
        $filteredData = $query->get();


        // Extract days, dailyPemasukan, and initialize dailyPengeluaran
        $days = LaporanKeuangan::orderBy('tanggal', 'asc')
            ->get()
            ->pluck('tanggal')
            ->toArray();

        // Data set for Pemasukan
        $dailyPemasukan = LaporanKeuangan::orderBy('tanggal', 'asc')
            ->get()
            ->pluck('pemasukan')
            ->toArray();

        // Data set for Pengeluaran
        $dailyPengeluaran = LaporanKeuangan::orderBy('tanggal', 'asc')
            ->get()
            ->pluck('pengeluaran')
            ->toArray();

        // Package the chart data
        $chartData = [
            'days' => $filteredData->pluck('tanggal')->toArray(),
            'pemasukanData' => $filteredData->pluck('pemasukan')->toArray(),
            'pengeluaranData' => $filteredData->pluck('pengeluaran')->toArray(),
        ];

        $filteredData = LaporanKeuangan::with('lokasiKos')
        ->when($selectedNamaKos != 'All', function ($query) use ($selectedNamaKos) {
            $query->whereHas('lokasiKos', function ($q) use ($selectedNamaKos) {
                $q->where('nama_kos', $selectedNamaKos);
            });
        })
        ->when($selectedBulan != 'All', function ($query) use ($selectedBulan) {
            $query->whereMonth('tanggal', $selectedBulan);
        })
        ->when($selectedTahun != 'All', function ($query) use ($selectedTahun) {
            $query->whereYear('tanggal', $selectedTahun);
        })
        ->get();

    // Calculate the net income for each location, month, and year
    $netIncomeResults = [];
    $showNetIncome = false; // Flag to determine if net income should be shown

    // Check if any filters are applied
    $filtersApplied = $request->has('nama_kos') || $request->has('bulan') || $request->has('tahun');

    if ($filtersApplied) {
        // Only calculate net income if filters are applied
        foreach ($filteredData as $data) {
            $location = $data->lokasiKos->nama_kos ?? 'Unknown Location';
            $month = Carbon::parse($data->tanggal)->format('F'); // Format to full text representation of a month, such as January or March
            $year = Carbon::parse($data->tanggal)->format('Y'); // Year in four digits
            $key = "{$location}-{$month}-{$year}";
        

            if (!isset($netIncomeResults[$key])) {
                $netIncomeResults[$key] = [
                    'location' => $location,
                    'month' => $month,
                    'year' => $year,
                    'net_income' => 0
                ];
            }

            $netIncomeResults[$key]['net_income'] += $data->pemasukan - $data->pengeluaran;
        }
        $showNetIncome = true; // Set to true to show net income results
    }




        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return view('dashboard.dashboard', compact(
            'totalKamar',
            'netIncomeResults',
            'filtersApplied',
            'showNetIncome',
            'totalLokasiKos',
            'totalKamarSudahTerisi',
            'totalKamarBelumTerisi',
            'totalPemasukan',
            'totalPengeluaran',
            'totalPenyewa',
            'totalPenyewaAktif',
            'totalTransaksi',
            'pemasukanData',
            'totalInvestor',
            'pengeluaranData',
            'pendapatanBersih',
            'months',
            'days',
            'dailyPemasukan',
            'dailyPengeluaran',
            'namaKosList',
            'bulanList',
            'tahunList',
            'selectedNamaKos',
            'selectedBulan',
            'selectedTahun',
            'chartData',
        ));
    }
}
