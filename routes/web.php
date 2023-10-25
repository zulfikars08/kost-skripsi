<?php

use App\Exports\TransaksiExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LokasiKostController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\TanggalController;
use App\Http\Controllers\TransaksiController;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\TanggalTransaksi;
use App\Models\Transaksi;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    // Redirect authenticated users to the dashboard
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });

    // Kamar routes
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::get('/kamar/create', [KamarController::class, 'create'])->name('kamar.create');
    Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::get('/showdata', [KamarController::class, 'showData'])->name('kamar.showData');
    Route::get('/kamar/{id}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
    Route::put('/kamar/{id}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{id}', [KamarController::class, 'destroy'])->name('kamar.destroy');

    // Penghuni routes
    Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penghuni.index');
    Route::get('/penghuni/create', [PenghuniController::class, 'create'])->name('penghuni.create');
    Route::post('/penghuni', [PenghuniController::class, 'store'])->name('penghuni.store');

    // Lokasi Kos routes
    Route::get('/lokasi_kos', [LokasiKostController::class, 'index'])->name('lokasi_kos.index');
    Route::get('/lokasi_kos/create', [LokasiKostController::class, 'create'])->name('lokasi_kos.create');
    Route::post('/lokasi_kos', [LokasiKostController::class, 'store'])->name('lokasi_kos.store');
    Route::get('/lokasi_kos/{id}/detail', [LokasiKostController::class, 'show'])->name('lokasi_kos.detail');
    Route::delete('/lokasi_kos/{id}', [LokasiKostController::class, 'destroy'])->name('lokasi_kos.destroy');

    // Dashboard
    Route::get('/penyewa', [PenyewaController::class, 'index'])->name('penyewa.index');
    Route::get('/penyewa/create', [PenyewaController::class, 'create'])->name('penyewa.create');
    Route::post('/penyewa', [PenyewaController::class, 'store'])->name('penyewa.store');
    Route::get('/penyewa/{id}/edit', [PenyewaController::class, 'edit'])->name('penyewa.edit');
    Route::put('/penyewa/{id}', [PenyewaController::class, 'update'])->name('penyewa.update');
    Route::get('penyewa/{id}/detail', [PenyewaController::class, 'show'])->name('penyewa.show');
    Route::delete('/penyewa/{id}', [PenyewaController::class, 'destroy'])->name('penyewa.destroy');

    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');


    Route::get('/lokasi', [LokasiKostController::class, 'lokasi'])->name('tanggal-transaksi.lokasi');
    Route::get('/tanggal-transaksi', [TanggalController::class, 'index'])->name('tanggal-transaksi.index');
    Route::get('/tanggal-transaksi/create', [TanggalController::class, 'create'])->name('tanggal-transaksi.create');
    Route::post('tanggal-transaksi', [TanggalController::class, 'store'])->name('tanggal-transaksi.store');
    Route::get('tanggal-transaksi/{id}/detail', [TanggalController::class, 'show'])->name('tanggal-transaksi.detail');
    Route::delete('/tanggal-transaksi/{id}', [TanggalController::class, 'destroy'])->name('tanggal-transaksi.destroy');
    
    Route::get('/laporan-keuangan', [TransaksiController::class, 'laporan'])->name('laporan-keuangan.laporan');
    Route::post('/laporan-keuangan', [TransaksiController::class, 'generateFinancialReport'])->name('laporan-keuangan.generate');
    Route::get('/export-all-transaksi', [TransaksiController::class, 'exportAllTransaksi'])->name('export-all-transaksi');
    Route::get('/export-filtered-transaksi', [TransaksiController::class, 'exportFilteredTransaksi'])->name('export-filtered-transaksi');
    Route::get('/transaksi/export-excel',  [TransaksiController::class, 'exportToExcel'])->name('transaksi.export.excel');

    Route::get('/generate-report', [TransaksiController::class, 'showGenerateFinancialReportView'])->name('show-generate-financial-report-view');
// Route to generate the financial report
    Route::post('/generate-report', [TransaksiController::class, 'generateFinancialReport'])->name('generate-financial-report');

});
Route::get('/register', [SesiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [SesiController::class, 'register']);

Route::get('/', [SesiController::class, 'index'])->name('login');
Route::post('/', [SesiController::class, 'login']);