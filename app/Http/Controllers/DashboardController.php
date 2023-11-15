<?php

namespace App\Http\Controllers;

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

class DashboardController extends Controller
{
    public function index()
    {
        sleep(1); // Simulating delay for loading
        $totalKamar = Kamar::count();
        $totalLokasiKos = LokasiKos::count();
    
        $totalKamarSudahTerisi = Kamar::where('status', 'sudah terisi')->count();
        $totalKamarBelumTerisi = Kamar::where('status', 'belum terisi')->count();
        $totalTransaksi = Transaksi::count();
        $totalPenyewa = Penyewa::count();
    
        // Filter data for the current month
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');
        $totalPemasukan = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->sum('pemasukan');
        $totalPengeluaran= LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->sum('pengeluaran');
        $pemasukanData = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->get();
        $pengeluaranData = LaporanKeuangan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->get();
    
        $pendapatanBersih = $totalPemasukan - $totalPengeluaran;
    
        // Extract days, dailyPemasukan, and initialize dailyPengeluaran
        $days = [];
        $dailyPemasukan = [];
        $dailyPengeluaran = [];
    
        // Populate days, dailyPemasukan, and dailyPengeluaran from your fetched data
        foreach ($pemasukanData as $pemasukan) {
            $days[] = $pemasukan->tanggal; // Assuming 'tanggal' is a string in "Y-m-d" format
            $dailyPemasukan[] = $pemasukan->pemasukan; // Use the correct field name
            $dailyPengeluaran[] = 0; // Initialize to 0
        }
    
        foreach ($pengeluaranData as $pengeluaran) {
            $dayIndex = array_search($pengeluaran->tanggal, $days);
    
            if ($dayIndex !== false) {
                $dailyPengeluaran[$dayIndex] += $pengeluaran->pengeluaran; // Use the correct field name
            } else {
                $days[] = $pengeluaran->tanggal;
                $dailyPemasukan[] = 0; // Assuming you don't have pemasukan data for each day
                $dailyPengeluaran[] = $pengeluaran->pengeluaran; // Use the correct field name
            }
        }
    
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return view('dashboard.dashboard', compact(
            'totalKamar',
            'totalLokasiKos',
            'totalKamarSudahTerisi',
            'totalKamarBelumTerisi',
            'totalPemasukan',
            'totalPengeluaran',
            'totalPenyewa',
            'totalTransaksi',
            'pemasukanData',
            'pengeluaranData',
            'pendapatanBersih',
            'months',
            'days',
            'dailyPemasukan',
            'dailyPengeluaran'
        ));
    }
    

}
