<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prodi');
            $table->string('gelar_depan')->nullable();
            $table->string('nama');
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nik')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->text('pendidikan_data')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('tmt_kerja')->nullable();
            $table->integer('masa_kerja_tahun')->nullable();
            $table->integer('masa_kerja_bulan')->nullable();
            $table->string('golongan')->nullable();
            $table->integer('masa_kerja_golongan_tahun')->nullable();
            $table->integer('masa_kerja_golongan_bulan')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->enum('sertifikasi', ['SUDAH', 'BELUM'])->default('BELUM');
            $table->enum('inpasing', ['SUDAH', 'BELUM'])->default('BELUM');
            $table->enum('status_dosen', ['DOSEN_TETAP', 'DOSEN_TIDAK_TETAP', 'PNS'])->default('DOSEN_TETAP');
            
            // Kolom dari migration ketiga
            $table->string('pangkat_golongan')->nullable();
            $table->string('jabatan_fungsional')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('no_sk_jafung')->nullable();
            
            // Kolom file dari migration kedua
            $table->string('file_sertifikasi')->nullable();
            $table->string('file_inpasing')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ijazah_s1')->nullable();
            $table->string('file_transkrip_s1')->nullable();
            $table->string('file_ijazah_s2')->nullable();
            $table->string('file_transkrip_s2')->nullable();
            $table->string('file_ijazah_s3')->nullable();
            $table->string('file_transkrip_s3')->nullable();
            $table->string('file_jafung')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_perjanjian_kerja')->nullable();
            $table->string('file_sk_pengangkatan')->nullable();
            $table->string('file_surat_pernyataan')->nullable();
            $table->string('file_sktp')->nullable();
            $table->string('file_surat_tugas')->nullable();
            $table->string('file_sk_aktif')->nullable();
            
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};