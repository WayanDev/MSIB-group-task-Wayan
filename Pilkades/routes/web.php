<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AkunDesaController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\ListDesaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AkunPemilihController;
use App\Http\Controllers\ListPemilihController;
use App\Http\Controllers\JadwalVotingController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\DashboardPemilihController;


// Mengarahkan langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/', [HomeController::class, 'showVotingResults'])->name('home');

// Route untuk halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::fallback(function () {
    return view('errorpage');
});

// Autentikasi dan otorisasi role admin pada tabel/guard akun_desa
Route::middleware(['auth:akun_desa','role:admin'])->group(function(){
    // Menu Dashboard Admin
    Route::get('/dashboardAdmin',[DashboardController::class, 'index'])->name('admin.dashboard');
    // Menu List Desa Admin
    Route::get('/list_desa', [ListDesaController::class, 'index'])->name('list_desa.index');
    Route::get('/list_desa/create', [ListDesaController::class, 'create'])->name('list_desa.create');
    Route::post('/list_desa', [ListDesaController::class, 'store'])->name('list_desa.store');
    Route::get('/list_desa/{nama}/edit', [ListDesaController::class, 'edit'])->name('list_desa.edit');
    Route::put('/list_desa/{nama}', [ListDesaController::class, 'update'])->name('list_desa.update');
    Route::delete('/list_desa/{nama}', [ListDesaController::class, 'destroy'])->name('list_desa.destroy');
    // Menu Akun Desa Admin
    Route::get('/akun_desa', [AkunDesaController::class, 'index'])->name('akun_desa.index');
    Route::get('/akun_desa/create', [AkunDesaController::class, 'create'])->name('akun_desa.create');
    Route::post('/akun_desa', [AkunDesaController::class, 'store'])->name('akun_desa.store');
    Route::get('/akun_desa/{id}/edit', [AkunDesaController::class, 'edit'])->name('akun_desa.edit');
    Route::put('/akun_desa/{id}', [AkunDesaController::class, 'update'])->name('akun_desa.update');
    Route::delete('/akun_desa/{id}', [AkunDesaController::class, 'destroy'])->name('akun_desa.destroy');
    // Menu Jadwal Voting Admin
    Route::get('/jadwal_voting', [JadwalVotingController::class, 'index'])->name('jadwal_voting.index');
    Route::get('/jadwal_voting/create', [JadwalVotingController::class, 'create'])->name('jadwal_voting.create');
    Route::post('/jadwal_voting', [JadwalVotingController::class, 'store'])->name('jadwal_voting.store');
    Route::get('/jadwal_voting/{id}/edit', [JadwalVotingController::class, 'edit'])->name('jadwal_voting.edit');
    Route::put('/jadwal_voting/{id}', [JadwalVotingController::class, 'update'])->name('jadwal_voting.update');
    Route::delete('/jadwal_voting/{id}', [JadwalVotingController::class, 'destroy'])->name('jadwal_voting.destroy');

    //Export Import Excel List Desa
    Route::get('/exportlistdesa', [ListDesaController::class, 'listdesaexport'])->name('exportlistdesa');
    Route::post('/importlistdesa', [ListDesaController::class, 'listdesaimport'])->name('importlistdesa');

    //Export Import Excel Akun Desa
    Route::get('/exportakundesa', [AkunDesaController::class, 'akundesaexport'])->name('exportakundesa');
    Route::post('/importakundesa', [AkunDesaController::class, 'akundesaimport'])->name('importakundesa');

    Route::get('/export-dashboard-pdf', [DashboardController::class, 'exportdashboard'])->name('export-dashboard-pdf');
});



// Autentikasi dan otorisasi role petugas pada tabel/guard akun_desa
Route::group(['middleware' => ['auth:akun_desa','role:petugas']],function(){
    // Menu Dashboard Petugas
    Route::get('/dashboardPetugas',[DashboardController::class, 'index'])->name('petugas.dashboard');
    // Menu Akun Pemilih Petugas
    Route::get('/akun_pemilih', [AkunPemilihController::class, 'index'])->name('akun_pemilih.index');
    Route::get('/akun_pemilih/create', [AkunPemilihController::class, 'create'])->name('akun_pemilih.create');
    Route::post('/akun_pemilih', [AkunPemilihController::class, 'store'])->name('akun_pemilih.store');
    Route::get('/akun_pemilih/{id}/edit', [AkunPemilihController::class, 'edit'])->name('akun_pemilih.edit');
    Route::put('/akun_pemilih/{id}', [AkunPemilihController::class, 'update'])->name('akun_pemilih.update');
    Route::delete('/akun_pemilih/{akun_pemilih}', [AkunPemilihController::class, 'destroy'])->name('akun_pemilih.destroy');
    // Menu Kandidat Petugas
    Route::get('/kandidatpetugas', [KandidatController::class, 'index'])->name('petugas.kandidat');
    Route::get('/kandidat/create', [KandidatController::class, 'create'])->name('kandidat.create');
    Route::post('/kandidat', [KandidatController::class, 'store'])->name('kandidat.store');
    Route::get('/kandidat/{id}/edit', [KandidatController::class, 'edit'])->name('kandidat.edit');
    Route::put('/kandidat/{id}', [KandidatController::class, 'update'])->name('kandidat.update');
    Route::delete('/kandidat/{id}', [KandidatController::class, 'destroy'])->name('kandidat.destroy');
    // Menu Hasil Voting Petugas
    Route::get('/Voting',[VotingController::class, 'index'])->name('voting.index');
    Route::delete('/Voting/{id}',[VotingController::class, 'destroy'])->name('voting.destroy');
    Route::delete('/voting/delete-all', [VotingController::class, 'destroyAll'])->name('voting.destroyAll');

    // Menu List Pemilih Petugas
    Route::get('/list_pemilih/create', [ListPemilihController::class, 'create'])->name('list_pemilih.create');
    Route::post('/list_pemilih', [ListPemilihController::class, 'store'])->name('list_pemilih.store');
    Route::get('/list_pemilih/{nik}/edit', [ListPemilihController::class, 'edit'])->name('list_pemilih.edit');
    Route::put('/list_pemilih/{nik}', [ListPemilihController::class, 'update'])->name('list_pemilih.update');
    Route::delete('/list_pemilih/{nik}', [ListPemilihController::class, 'destroy'])->name('list_pemilih.destroy');

    //Export Import Excel List Pemilih
    Route::get('/exportlistpemilih', [ListPemilihController::class, 'listpemilihexport'])->name('exportlistpemilih');
    Route::post('/importlistpemilih', [ListPemilihController::class, 'listpemilihimport'])->name('importlistpemilih');
    //Export Import Excel Akun Pemilih
    Route::get('/exportakunpemilih', [AkunPemilihController::class, 'akunpemilihexport'])->name('exportakunpemilih');
    Route::post('/importakunpemilih', [AkunPemilihController::class, 'akunpemilihimport'])->name('importakunpemilih');

    Route::get('/export-dashboard-pdf-petugas', [DashboardController::class, 'exportdashboardpetugas'])->name('export-dashboard-pdf-petugas');
});



// Autentikasi dan otorisasi halaman yang hanya boleh diakses oleh admin dan petugas
Route::group(['middleware' => ['auth:akun_desa','role:admin,petugas']],function(){
    // Menu List Pemilih Admin dan Petugas
    Route::get('/list_pemilih', [ListPemilihController::class, 'index'])->name('list_pemilih.index');

    Route::get('/export-pemilih', [ListPemilihController::class, 'exportpemilih'])->name('export-pemilih');

    Route::post('/admin/dashboard/select', [DashboardController::class, 'selectDashboard'])->name('dashboard.select');

});



// Autentikasi dan otorisasi pada tabel/guard pemilih
Route::group(['middleware' => ['auth:pemilih','logout']],function(){
    // Menu Dashboard Pemilih
    Route::get('/pemilihDashboard',[DashboardPemilihController::class, 'index'])->name('pemilih.dashboard');
    // Menu Kandidat Pemilih
    Route::get('/kandidatpemilih', [KandidatController::class, 'show'])->name('pemilih.kandidat');
    // Proses klik pilih pada kandidat
    Route::post('/voting',[VotingController::class, 'store'])->name('voting.store');
});


// Autentikasi dan otorisasi jika halaman URL tidak tersedia
Route::group(['middleware' => ['auth:akun_desa,pemilih']],function(){
    Route::fallback(function () {return view('errorpage');});
});


