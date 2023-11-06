<?php

use App\Exports\TransaksiExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LokasiKostController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\SuperadminController;
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
    Route::delete('/penyewa/{id}', [PenyewaController::class, 'destroy'])->name('penyewa.destroy');

    // penghuni routes
    Route::get('/penyewa/detail/{id}', [PenyewaController::class, 'show'])->name('penyewa.penghuni.index');
    Route::get('/penyewa/create', [PenghuniController::class, 'create'])->name('penyewa.penghuni.create');
    Route::post('/penyewa', [PenghuniController::class, 'store'])->name('penghuni.store');

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
    });
});
