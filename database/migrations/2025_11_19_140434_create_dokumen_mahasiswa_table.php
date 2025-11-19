<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique(); // Satu NIM satu record
            $table->string('nama_lengkap');
            $table->foreignId('prodi_id')->constrained('prodi'); // Relasi ke prodi
            $table->year('tahun_masuk');
            $table->year('tahun_keluar')->nullable();
            $table->enum('status_mahasiswa', ['Aktif', 'Lulus', 'Cuti', 'Drop Out'])->default('Aktif');
            $table->string('file_ijazah')->nullable();
            $table->string('file_transkrip')->nullable();
            $table->enum('status_verifikasi', ['Terverifikasi', 'Menunggu', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('admin_verifikator_id')->nullable()->constrained('users');
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_mahasiswa');
    }
};