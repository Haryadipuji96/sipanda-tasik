<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Login khusus
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

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
