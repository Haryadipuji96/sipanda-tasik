<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSarprasController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\KategoriArsipController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenagaPendidikController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user-activity', [UserLoginController::class, 'index'])->name('userlogin.index');
});

// Route::get('/sarpras/laporan', [DataSarprasController::class, 'laporan'])->name('sarpras.laporan');
Route::get('/sarpras/laporan/preview', [DataSarprasController::class, 'preview'])->name('sarpras.laporan.preview');
Route::get('/sarpras/laporan/pdf', [DataSarprasController::class, 'laporanPDF'])->name('sarpras.laporan.pdf');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::delete('dosen/delete-selected', [DosenController::class, 'deleteSelected'])->name('dosen.deleteSelected');
Route::delete('arsip/delete-selected', [ArsipController::class, 'deleteSelected'])->name('arsip.deleteSelected');
Route::delete('sarpras/delete-selected', [DataSarprasController::class, 'deleteSelected'])->name('sarpras.deleteSelected');
Route::delete('tenaga-pendidik/delete-selected', [TenagaPendidikController::class, 'deleteSelected'])->name('tenaga-pendidik.deleteSelected');



// // Login khusus
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);

// // Logout
// Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('fakultas', FakultasController::class);
    Route::resource('prodi', ProdiController::class);
    Route::resource('kategori-arsip', KategoriArsipController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('users', UserController::class);
    Route::resource('arsip', ArsipController::class);
    Route::resource('sarpras', DataSarprasController::class);
    Route::resource('tenaga-pendidik', TenagaPendidikController::class);
    Route::get('userlogin', [UserLoginController::class, 'index'])->name('userlogin.index');
});

require __DIR__ . '/auth.php';
