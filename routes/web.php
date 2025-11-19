<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataSarprasController;
use App\Http\Controllers\DokumenMahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\KategoriArsipController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
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
    Route::get('/user-activity/{userId}/detail', [UserLoginController::class, 'detail'])->name('userlogin.detail');
});


Route::prefix('dosen')->group(function () {
    Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/store', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/{id}', [DosenController::class, 'show'])->name('dosen.show');
    Route::put('/{id}', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/{id}', [DosenController::class, 'destroy'])->name('dosen.destroy');
    Route::delete('/delete-selected', [DosenController::class, 'deleteSelected'])->name('dosen.deleteSelected');

    // Export Routes
    Route::get('/export/excel', [DosenController::class, 'exportExcel'])->name('dosen.export.excel');
    Route::get('/preview/pdf', [DosenController::class, 'previewAllPdf'])->name('dosen.preview.pdf');
    Route::get('/download/pdf', [DosenController::class, 'downloadAllPdf'])->name('dosen.download-all.pdf');

    // PDF Single Routes - HARUS SEBELUM ROUTE {id}
    Route::get('/{id}/preview-pdf', [DosenController::class, 'previewPdfSingle'])->name('dosen.preview-single.pdf');
    Route::get('/{id}/download-pdf', [DosenController::class, 'downloadPdfSingle'])->name('dosen.download-single.pdf');
});

// ==========================================
// ROUTE UNTUK TENAGA PENDIDIK
// ==========================================
// Route untuk PDF Single Tendik (dari show)
Route::get('/tenaga-pendidik/{id}/preview-pdf', [TenagaPendidikController::class, 'previewPDF'])->name('tenaga-pendidik.preview-pdf');
Route::get('/tenaga-pendidik/{id}/download-pdf', [TenagaPendidikController::class, 'downloadPDF'])->name('tenaga-pendidik.download-pdf');

// Route untuk PDF Semua Data Tendik (dari index)
Route::get('/tenaga-pendidik/preview-all-pdf', [TenagaPendidikController::class, 'previewAllPdf'])->name('tenaga-pendidik.preview-all.pdf');
Route::get('/tenaga-pendidik/download-all-pdf', [TenagaPendidikController::class, 'downloadAllPdf'])->name('tenaga-pendidik.download-all.pdf');
Route::get('/tenaga-pendidik/export-excel', [TenagaPendidikController::class, 'exportExcel'])->name('tenaga-pendidik.export.excel');

// ==========================================
// ROUTE UNTUK SARPRAS
// ==========================================
// // Route untuk PDF per ruangan
Route::get('/sarpras/{id}/ruangan-pdf', [DataSarprasController::class, 'ruanganPDF'])->name('sarpras.ruangan.pdf');
// Route::get('/sarpras/laporan/preview', [DataSarprasController::class, 'previewHTML'])->name('sarpras.laporan.preview');
Route::get('/sarpras/laporan/pdf', [DataSarprasController::class, 'laporanPDF'])->name('sarpras.laporan.pdf');
// Route::get('/sarpras/export-excel', [DataSarprasController::class, 'exportExcel'])->name('sarpras.export.excel');
// // routes/web.php - tambahkan ini di section sarpras

// // Routes untuk tambah barang dari ruangan
Route::get('/ruangan/{id}/tambah-barang', [DataSarprasController::class, 'createFromRuangan'])->name('ruangan.tambah-barang');
Route::post('/ruangan/{id}/simpan-barang', [DataSarprasController::class, 'storeFromRuangan'])->name('ruangan.simpan-barang');

// // Route untuk lihat detail ruangan + barangnya
// Route::get('/ruangan/{id}/barang', [DataSarprasController::class, 'showRuangan'])->name('ruangan.show');
// Tambahkan route baru untuk detail barang di ruangan
Route::get('/ruangan/{ruangan}/barang/{barang}', [App\Http\Controllers\RuanganController::class, 'showBarang'])
    ->name('ruangan.detail.show');
// Tambahkan route untuk download PDF per ruangan
Route::get('/ruangan/{ruangan}/pdf', [App\Http\Controllers\RuanganController::class, 'downloadPdf'])
    ->name('ruangan.pdf');
// Route untuk menampilkan form tambah barang
Route::get('/ruangan/{ruangan}/tambah-barang', [App\Http\Controllers\RuanganController::class, 'tambahBarang'])
    ->name('ruangan.tambah-barang');

// Route untuk menyimpan barang baru
Route::post('/ruangan/{ruangan}/simpan-barang', [App\Http\Controllers\RuanganController::class, 'simpanBarang'])
    ->name('ruangan.simpan-barang');
// Route untuk edit barang dalam ruangan
Route::get('/ruangan/{ruangan}/barang/{barang}/edit', [App\Http\Controllers\RuanganController::class, 'editBarang'])
    ->name('ruangan.barang.edit');
Route::put('/ruangan/{ruangan}/barang/{barang}', [App\Http\Controllers\RuanganController::class, 'updateBarang'])
    ->name('ruangan.barang.update');
Route::delete('/ruangan/{ruangan}/barang/{barang}', [App\Http\Controllers\RuanganController::class, 'destroyBarang'])
    ->name('ruangan.barang.destroy');

// ==========================================
// ROUTE UNTUK ARSIP (jika ada)
// ==========================================
// Route untuk PDF Semua Data Arsip (dari index)
Route::get('/arsip/preview-all-pdf', [ArsipController::class, 'previewAllPdf'])->name('arsip.preview-all.pdf');
Route::get('/arsip/download-all-pdf', [ArsipController::class, 'downloadAllPdf'])->name('arsip.download-all.pdf');
Route::get('/arsip/export-excel', [ArsipController::class, 'exportExcel'])->name('arsip.export.excel');

// Route untuk PDF Single Arsip (dari show) - jika diperlukan
Route::get('/arsip/{id}/preview-pdf', [ArsipController::class, 'previewPdfSingle'])->name('arsip.preview-single.pdf');
Route::get('/arsip/{id}/download-pdf', [ArsipController::class, 'downloadPdfSingle'])->name('arsip.download-single.pdf');

// ==========================================
// ROUTE UNTUK PRODI (jika butuh export)
// ==========================================
Route::get('/prodi/export-excel', [ProdiController::class, 'exportExcel'])->name('prodi.export.excel');
Route::get('/prodi/preview-pdf', [ProdiController::class, 'previewPdf'])->name('prodi.preview.pdf');
Route::get('/prodi/download-pdf', [ProdiController::class, 'downloadPdf'])->name('prodi.download.pdf');

// ==========================================
// ROUTE UNTUK FAKULTAS (jika butuh export)
// ==========================================
Route::get('/fakultas/export-excel', [FakultasController::class, 'exportExcel'])->name('fakultas.export.excel');
Route::get('/fakultas/preview-pdf', [FakultasController::class, 'previewPdf'])->name('fakultas.preview.pdf');
Route::get('/fakultas/download-pdf', [FakultasController::class, 'downloadPdf'])->name('fakultas.download.pdf');

// AJAX Routes untuk Ruangan
// Route::get('/get-prodi/{id_fakultas}', [DataSarprasController::class, 'getProdiByFakultas'])->name('get.prodi.by.fakultas');
// MENJADI INI:
Route::get('/get-prodi/{id_fakultas}', [RuanganController::class, 'getProdiByFakultas'])->name('get.prodi.by.fakultas');
Route::get('/ruangan/create-akademik', [RuanganController::class, 'createAkademik'])->name('ruangan.create.akademik');
Route::get('/ruangan/create-umum', [RuanganController::class, 'createUmum'])->name('ruangan.create.umum');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/dokumen-mahasiswa/{id}/verifikasi', [DokumenMahasiswaController::class, 'verifikasi'])->name('dokumen-mahasiswa.verifikasi');

// Bulk Delete Routes - PASTIKAN SEMUA DI DALAM MIDDLEWARE AUTH
Route::middleware('auth')->group(function () {
    // Bulk Delete Routes
    Route::delete('dosen/delete-selected', [DosenController::class, 'deleteSelected'])->name('dosen.deleteSelected');
    Route::delete('arsip/delete-selected', [ArsipController::class, 'deleteSelected'])->name('arsip.deleteSelected');
    // Route::delete('sarpras/delete-selected', [DataSarprasController::class, 'deleteSelected'])->name('sarpras.deleteSelected');
    Route::delete('tenaga-pendidik/delete-selected', [TenagaPendidikController::class, 'deleteSelected'])->name('tenaga-pendidik.deleteSelected');
    Route::delete('ruangan/delete-selected', [RuanganController::class, 'deleteSelected'])->name('ruangan.deleteSelected');

    // Resource Routes
    Route::resource('fakultas', FakultasController::class);
    Route::resource('prodi', ProdiController::class);
    Route::resource('kategori-arsip', KategoriArsipController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('users', UserController::class);
    Route::resource('arsip', ArsipController::class);
    // Route::resource('sarpras', DataSarprasController::class);
    Route::resource('tenaga-pendidik', TenagaPendidikController::class);
    Route::resource('ruangan', RuanganController::class);
    Route::resource('dokumen-mahasiswa', DokumenMahasiswaController::class);
});

require __DIR__ . '/auth.php';
