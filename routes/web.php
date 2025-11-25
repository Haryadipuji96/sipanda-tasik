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

// ==========================================
// ROUTE UNTUK DOSEN
// ==========================================
Route::prefix('dosen')->group(function () {
    Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/store', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/{id}', [DosenController::class, 'show'])->name('dosen.show');
    Route::put('/{id}', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/{id}', [DosenController::class, 'destroy'])->name('dosen.destroy');
    Route::post('/delete-selected', [DosenController::class, 'deleteSelected'])->name('dosen.deleteSelected');

    // Export Routes
    Route::get('/export/excel', [DosenController::class, 'exportExcel'])->name('dosen.export.excel');
    Route::get('/preview/pdf', [DosenController::class, 'previewAllPdf'])->name('dosen.preview.pdf');
    Route::get('/download/pdf', [DosenController::class, 'downloadAllPdf'])->name('dosen.download-all.pdf');

    // PDF Single Routes
    Route::get('/{id}/preview-pdf', [DosenController::class, 'previewPdfSingle'])->name('dosen.preview-single.pdf');
    Route::get('/{id}/download-pdf', [DosenController::class, 'downloadPdfSingle'])->name('dosen.download-single.pdf');
});

// ==========================================
// ROUTE UNTUK TENAGA PENDIDIK
// ==========================================
Route::prefix('tenaga-pendidik')->group(function () {
    Route::get('/', [TenagaPendidikController::class, 'index'])->name('tenaga-pendidik.index');
    Route::get('/create', [TenagaPendidikController::class, 'create'])->name('tenaga-pendidik.create');
    Route::post('/store', [TenagaPendidikController::class, 'store'])->name('tenaga-pendidik.store');

    // Export Routes - HARUS DITARUH SEBELUM DYNAMIC ROUTES
    Route::get('/export/excel', [TenagaPendidikController::class, 'exportExcel'])->name('tenaga-pendidik.export.excel');
    Route::get('/preview-all-pdf', [TenagaPendidikController::class, 'previewAllPdf'])->name('tenaga-pendidik.preview-all.pdf');
    Route::get('/download-all-pdf', [TenagaPendidikController::class, 'downloadAllPdf'])->name('tenaga-pendidik.download-all.pdf');

    // Dynamic routes - HARUS DITARUH DI BAWAH
    Route::get('/{id}', [TenagaPendidikController::class, 'show'])->name('tenaga-pendidik.show');
    Route::put('/{id}', [TenagaPendidikController::class, 'update'])->name('tenaga-pendidik.update');
    Route::delete('/{id}', [TenagaPendidikController::class, 'destroy'])->name('tenaga-pendidik.destroy');
    Route::get('/{id}/preview-pdf', [TenagaPendidikController::class, 'previewPDF'])->name('tenaga-pendidik.preview-pdf');
    Route::get('/{id}/download-pdf', [TenagaPendidikController::class, 'downloadPDF'])->name('tenaga-pendidik.download-pdf');

    Route::post('/delete-selected', [TenagaPendidikController::class, 'deleteSelected'])->name('tenaga-pendidik.deleteSelected');
});
// ==========================================
// ROUTE UNTUK SARPRAS
// ==========================================
// Route::prefix('sarpras')->group(function () {
//     Route::get('/{id}/ruangan-pdf', [DataSarprasController::class, 'ruanganPDF'])->name('sarpras.ruangan.pdf');
//     Route::get('/laporan/pdf', [DataSarprasController::class, 'laporanPDF'])->name('sarpras.laporan.pdf');
// });

// ==========================================
// ROUTE UNTUK RUANGAN (FIXED - PERBAIKAN UTAMA)
// ==========================================
Route::prefix('ruangan')->group(function () {
    // Export dan utilitas
    Route::get('/{ruangan}/pdf', [RuanganController::class, 'downloadPdf'])->name('ruangan.pdf');
    Route::get('/{id}/import-barang', [RuanganController::class, 'showImportBarangForm'])->name('ruangan.import-barang-form');
    Route::post('/{id}/import-barang', [RuanganController::class, 'importBarang'])->name('ruangan.import-barang');
    Route::get('/{id}/download-template-barang', [RuanganController::class, 'downloadTemplateBarang'])->name('ruangan.download-template-barang');

    // Routes untuk import ruangan (jika diperlukan)
    Route::get('/import', [RuanganController::class, 'showImportForm'])->name('ruangan.import-form');
    Route::post('/import', [RuanganController::class, 'import'])->name('ruangan.import');
    Route::get('/download-template', [RuanganController::class, 'downloadTemplate'])->name('ruangan.download-template');
    // Route utama untuk ruangan
    Route::get('/', [RuanganController::class, 'index'])->name('ruangan.index');
    Route::get('/create', [RuanganController::class, 'create'])->name('ruangan.create');
    Route::post('/', [RuanganController::class, 'store'])->name('ruangan.store');
    Route::get('/{ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');
    Route::get('/{ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
    Route::put('/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
    Route::delete('/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

    // Route khusus untuk tipe ruangan - INI YANG DIPERBAIKI
    Route::get('/create/sarana', [RuanganController::class, 'createSarana'])->name('ruangan.create.sarana');
    Route::get('/create/prasarana', [RuanganController::class, 'createPrasarana'])->name('ruangan.create.prasarana');

    // Route untuk barang dalam ruangan
    Route::get('/{ruangan}/tambah-barang', [RuanganController::class, 'tambahBarang'])->name('ruangan.tambah-barang');
    Route::post('/{ruangan}/simpan-barang', [RuanganController::class, 'simpanBarang'])->name('ruangan.simpan-barang');
    Route::get('/{ruangan}/barang/{barang}', [RuanganController::class, 'showBarang'])->name('ruangan.barang.show');
    Route::get('/{ruangan}/barang/{barang}/edit', [RuanganController::class, 'editBarang'])->name('ruangan.barang.edit');
    Route::put('/{ruangan}/barang/{barang}', [RuanganController::class, 'updateBarang'])->name('ruangan.barang.update');
    Route::delete('/{ruangan}/barang/{barang}', [RuanganController::class, 'destroyBarang'])->name('ruangan.barang.destroy');

    Route::post('/ruangan/check-used-rooms', [RuanganController::class, 'checkUsedRooms'])->name('ruangan.checkUsedRooms');
    Route::post('/ruangan/delete-selected', [RuanganController::class, 'deleteSelected'])->name('ruangan.deleteSelected');
});

// ==========================================
// ROUTE UNTUK ARSIP
// ==========================================
Route::prefix('arsip')->group(function () {
    Route::get('/', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/create', [ArsipController::class, 'create'])->name('arsip.create');
    Route::post('/', [ArsipController::class, 'store'])->name('arsip.store');

    Route::get('/{arsip}/edit', [ArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/{arsip}', [ArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/{arsip}', [ArsipController::class, 'destroy'])->name('arsip.destroy');
    Route::post('/delete-selected', [ArsipController::class, 'deleteSelected'])->name('arsip.deleteSelected');

    // Export Routes
    Route::get('/export/excel', [ArsipController::class, 'exportExcel'])->name('arsip.export.excel');
    Route::get('/preview-all-pdf', [ArsipController::class, 'previewAllPdf'])->name('arsip.preview-all.pdf');
    Route::get('/download-all-pdf', [ArsipController::class, 'downloadAllPdf'])->name('arsip.download-all.pdf');
    Route::get('/{id}/preview-pdf', [ArsipController::class, 'previewPdfSingle'])->name('arsip.preview-single.pdf');
    Route::get('/{id}/download-pdf', [ArsipController::class, 'downloadPdfSingle'])->name('arsip.download-single.pdf');
});

// ==========================================
// ROUTE UNTUK PRODI
// ==========================================
Route::prefix('prodi')->group(function () {
    Route::get('/', [ProdiController::class, 'index'])->name('prodi.index');
    Route::get('/create', [ProdiController::class, 'create'])->name('prodi.create');
    Route::post('/', [ProdiController::class, 'store'])->name('prodi.store');
    Route::get('/{prodi}', [ProdiController::class, 'show'])->name('prodi.show');
    Route::get('/{prodi}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
    Route::put('/{prodi}', [ProdiController::class, 'update'])->name('prodi.update');
    Route::delete('/{prodi}', [ProdiController::class, 'destroy'])->name('prodi.destroy');

    // Export Routes
    Route::get('/export/excel', [ProdiController::class, 'exportExcel'])->name('prodi.export.excel');
    Route::get('/preview-pdf', [ProdiController::class, 'previewPdf'])->name('prodi.preview.pdf');
    Route::get('/download-pdf', [ProdiController::class, 'downloadPdf'])->name('prodi.download.pdf');
});

// ==========================================
// ROUTE UNTUK FAKULTAS
// ==========================================
Route::prefix('fakultas')->group(function () {
    Route::get('/', [FakultasController::class, 'index'])->name('fakultas.index');
    Route::get('/create', [FakultasController::class, 'create'])->name('fakultas.create');
    Route::post('/', [FakultasController::class, 'store'])->name('fakultas.store');
    Route::get('/{fakultas}', [FakultasController::class, 'show'])->name('fakultas.show');
    Route::get('/{fakultas}/edit', [FakultasController::class, 'edit'])->name('fakultas.edit');
    Route::put('/{fakultas}', [FakultasController::class, 'update'])->name('fakultas.update');
    Route::delete('/{fakultas}', [FakultasController::class, 'destroy'])->name('fakultas.destroy');

    // Export Routes
    Route::get('/export/excel', [FakultasController::class, 'exportExcel'])->name('fakultas.export.excel');
    Route::get('/preview-pdf', [FakultasController::class, 'previewPdf'])->name('fakultas.preview.pdf');
    Route::get('/download-pdf', [FakultasController::class, 'downloadPdf'])->name('fakultas.download.pdf');
});

// ==========================================
// ROUTE UNTUK DOKUMEN MAHASISWA
// ==========================================
Route::prefix('dokumen-mahasiswa')->group(function () {
    // Route untuk import dan template harus diletakkan sebelum route dengan parameter
    Route::get('/import', [DokumenMahasiswaController::class, 'showImportForm'])->name('dokumen-mahasiswa.import-form');
    Route::post('/import', [DokumenMahasiswaController::class, 'import'])->name('dokumen-mahasiswa.import');
    Route::get('/download-template', [DokumenMahasiswaController::class, 'downloadTemplate'])->name('dokumen-mahasiswa.download-template');

    // Route create harus sebelum route dengan parameter
    Route::get('/create', [DokumenMahasiswaController::class, 'create'])->name('dokumen-mahasiswa.create');
    Route::post('/', [DokumenMahasiswaController::class, 'store'])->name('dokumen-mahasiswa.store');

    // Route index
    Route::get('/', [DokumenMahasiswaController::class, 'index'])->name('dokumen-mahasiswa.index');

    // Route dengan parameter - pastikan konsisten menggunakan {id} atau {dokumen_mahasiswa}
    Route::get('/{id}', [DokumenMahasiswaController::class, 'show'])->name('dokumen-mahasiswa.show');
    Route::get('/{id}/edit', [DokumenMahasiswaController::class, 'edit'])->name('dokumen-mahasiswa.edit');
    Route::put('/{id}', [DokumenMahasiswaController::class, 'update'])->name('dokumen-mahasiswa.update');
    Route::delete('/{id}', [DokumenMahasiswaController::class, 'destroy'])->name('dokumen-mahasiswa.destroy');
});

// ==========================================
// ROUTE UNTUK KATEGORI ARSIP
// ==========================================
Route::prefix('kategori-arsip')->group(function () {
    Route::get('/', [KategoriArsipController::class, 'index'])->name('kategori-arsip.index');
    Route::get('/create', [KategoriArsipController::class, 'create'])->name('kategori-arsip.create');
    Route::post('/', [KategoriArsipController::class, 'store'])->name('kategori-arsip.store');
    Route::get('/{kategori_arsip}', [KategoriArsipController::class, 'show'])->name('kategori-arsip.show');
    Route::get('/{kategori_arsip}/edit', [KategoriArsipController::class, 'edit'])->name('kategori-arsip.edit');
    Route::put('/{kategori_arsip}', [KategoriArsipController::class, 'update'])->name('kategori-arsip.update');
    Route::delete('/{kategori_arsip}', [KategoriArsipController::class, 'destroy'])->name('kategori-arsip.destroy');
});

// ==========================================
// ROUTE UNTUK USERS
// ==========================================
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ==========================================
// AJAX ROUTES
// ==========================================
Route::get('/get-prodi/{id_fakultas}', [RuanganController::class, 'getProdiByFakultas'])->name('get.prodi.by.fakultas');
Route::get('/get-ruangan/{id_prodi}', [RuanganController::class, 'getRuanganByProdi'])->name('get.ruangan.by.prodi');

// ==========================================
// PROFILE ROUTES
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// BULK DELETE ROUTES (AUTH ONLY)
// ==========================================
// Route::middleware('auth')->group(function () {
//     // Route::post('/ruangan/check-used-rooms', [RuanganController::class, 'checkUsedRooms'])->name('ruangan.checkUsedRooms');
//     // Route::post('/ruangan/delete-selected', [RuanganController::class, 'deleteSelected'])->name('ruangan.deleteSelected');
//     // Route::delete('/dosen/delete-selected', [DosenController::class, 'deleteSelected'])->name('dosen.deleteSelected');
//     // Route::post('/tenaga-pendidik/delete-selected', [TenagaPendidikController::class, 'deleteSelected'])->name('tenaga-pendidik.deleteSelected');
// });

require __DIR__ . '/auth.php';
