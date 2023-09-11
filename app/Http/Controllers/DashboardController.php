<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\LokasiKos;
use App\Models\Penghuni; // Import model Penghuni jika belum diimpor
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
    
        $totalPenghuni = Penghuni::count(); // Menghitung jumlah total penghuni
    
        return view('dashboard.dashboard', compact('totalKamar', 'totalLokasiKos', 'totalKamarSudahTerisi', 'totalKamarBelumTerisi', 'totalPenghuni'));

    }
}
