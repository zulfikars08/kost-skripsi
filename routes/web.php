<?php

use App\Exports\TransaksiExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\LokasiKostController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\TanggalController;
use App\Http\Controllers\TanggalInvestorController;
use App\Http\Controllers\TanggalLaporanController;
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

Route::get('/register', [SesiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [SesiController::class, 'register']);

Route::get('/', [SesiController::class, 'index'])->name('login');
Route::post('/', [SesiController::class, 'login']);


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

    // penyewa routes
    Route::get('/penyewa', [PenyewaController::class, 'index'])->name('penyewa.index');
    Route::get('/penyewa/create', [PenyewaController::class, 'create'])->name('penyewa.create');
    Route::post('/penyewa', [PenyewaController::class, 'store'])->name('penyewa.store');
    Route::get('/penyewa/{id}/edit', [PenyewaController::class, 'edit'])->name('penyewa.edit');
    Route::put('/penyewa/{id}', [PenyewaController::class, 'update'])->name('penyewa.update');
    Route::get('penyewa/{id}/detail', [PenyewaController::class, 'show'])->name('penyewa.show');
    Route::delete('/penyewa/{id}', [PenyewaController::class, 'destroy'])->name('penyewa.destroy');


    // penghuni routes
    Route::get('/penyewa/detail/{id}', [PenyewaController::class, 'show'])->name('penyewa.penghuni.index');
    // Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penyewa.penghuni.index');
    Route::get('/penghuni/create', [PenghuniController::class, 'create'])->name('penyewa.penghuni.create');
    Route::post('/penyewa/detail/{id}', [PenghuniController::class, 'store'])->name('penyewa.detail.store');
    Route::delete('/penghuni/{id}', [PenghuniController::class, 'destroy'])->name('penyewa.penghuni.destroy');
    Route::get('/penghuni/{id}/edit', [PenghuniController::class, 'edit'])->name('penyewa.penghuni.edit');
    Route::put('/penghuni/{id}', [PenghuniController::class, 'update'])->name('penghuni.update');

    Route::get('/investor', [InvestorController::class, 'index'])->name('investor.detail.index');
    Route::get('/investor/create', [InvestorController::class, 'create'])->name('investor.detail.create');
    Route::post('/investor', [InvestorController::class, 'store'])->name('investor.store');
    Route::get('investor/{lokasi_id}/{bulan}/{tahun}', [TanggalInvestorController::class, 'show'])
        ->name('investor.detail.show');
    Route::get('/tanggal-investor', [TanggalInvestorController::class, 'index'])->name('investor.index');
    Route::get('/tanggal-investor/create', [TanggalInvestorController::class, 'create'])->name('investor.create');
    Route::post('/tanggal-investor', [TanggalInvestorController::class, 'store'])->name('tanggal-investor.store');

    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::get('/pemasukan/create', [PemasukanController::class, 'create'])->name('pemasukan.create');
    Route::post('/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::get('/pemasukan/{id}/edit', [PemasukanController::class, 'edit'])->name('pemasukan.edit');
    Route::put('/pemasukan/{id}', [PemasukanController::class, 'update'])->name('pemasukan.update');
   

    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');

    // Route::middleware('role:user')->group(function () {

    // });

    Route::middleware('role:admin')->group(function () {
         // lokasi routes
        Route::get('/lokasi_kos', [LokasiKostController::class, 'index'])->name('lokasi_kos.index');
        Route::get('/lokasi_kos/create', [LokasiKostController::class, 'create'])->name('lokasi_kos.create');
        Route::post('/lokasi_kos', [LokasiKostController::class, 'store'])->name('lokasi_kos.store');
        Route::get('/lokasi_kos/{id}/detail', [LokasiKostController::class, 'show'])->name('lokasi_kos.detail');
        Route::delete('/lokasi_kos/{id}', [LokasiKostController::class, 'destroy'])->name('lokasi_kos.destroy');

        //transaksi routes
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::resource('transaksi', TransaksiController::class);
        Route::get('/transaksi/filter', [TransaksiController::class, 'filterTransaksi'])->name('transaksi.filter');
        Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');

        //manage user route
        Route::get('/manage-users', [ManageUserController::class, 'index'])->name('manage-users.index');
        Route::post('/manage-users/create', [ManageUserController::class, 'create'])->name('manage-users.create');
        Route::get('/manage-users/{user}/edit', [ManageUserController::class, 'edit'])->name('manage-users.edit');
        Route::patch('/manage-users/{user}', [ManageUserController::class, 'update'])->name('manage-users.update');

        //excel route
        Route::get('/generate-report', [TransaksiController::class, 'showGenerateFinancialReportView'])->name('show-generate-financial-report-view');
        Route::post('/generate-report', [TransaksiController::class, 'generateFinancialReport'])->name('generate-financial-report');

        //laporan keuangan route
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan.detail.index');
        Route::get('/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('laporan-keuangan.create');
        Route::post('/laporan-keuangan', [LaporanKeuanganController::class, 'store'])->name('laporan-keuangan.store');
        Route::get('/laporan-keuangan/{id}/edit', [LaporanKeuanganController::class, 'edit'])->name('laporan-keuangan.edit');
        Route::put('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'update'])->name('laporan-keuangan.update');
        Route::get('laporan-keuangan/detail/{lokasi_id}/{bulan}/{tahun}', [TanggalLaporanController::class, 'showDetail'])
            ->name('laporan-keuangan.detail.show');
        Route::get('/export-laporan-keuangan', [LaporanKeuanganController::class, 'export'])->name('laporan-keuangan.export');
        Route::get('/generate-report', [LaporanKeuanganController::class, 'showGenerateFinancialReportView'])->name('show-generate-financial-report-view');
        Route::post('/generate-report', [LaporanKeuanganController::class, 'generateFinancialReport'])->name('generate-financial-report');
        Route::delete('/laporan-keuangan/{id}', [LaporanKeuanganController::class, 'destroy'])->name('laporan-keuangan.detail.destroy');
        //tanggal laporan route
        Route::get('/tanggal-laporan', [TanggalLaporanController::class, 'index'])->name('laporan-keuangan.index');
        Route::get('/tanggal-laporan/create', [TanggalLaporanController::class, 'create'])->name('laporan-keuangan.create');
        Route::post('/tanggal-laporan', [TanggalLaporanController::class, 'store'])->name('tanggal-laporan.store');


    });
});
