<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenaga_pendidik', function (Blueprint $table) {
            // Ubah relasi prodi menjadi nullable
            $table->foreignId('id_prodi')->nullable()->change();
            
            // Ubah enum status kepegawaian
            $table->enum('status_kepegawaian', ['PNS', 'Non PNS Tetap', 'Non PNS Tidak Tetap'])->default('Non PNS Tidak Tetap')->change();
            
            // Tambah field jabatan_struktural
            $table->string('jabatan_struktural')->nullable();
            
            // Tambah field untuk upload berkas
            $table->string('file_ktp')->nullable();
            $table->string('file_ijazah_s1')->nullable();
            $table->string('file_transkrip_s1')->nullable();
            $table->string('file_ijazah_s2')->nullable();
            $table->string('file_transkrip_s2')->nullable();
            $table->string('file_ijazah_s3')->nullable();
            $table->string('file_transkrip_s3')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_perjanjian_kerja')->nullable();
            $table->string('file_sk')->nullable();
            $table->string('file_surat_tugas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tenaga_pendidik', function (Blueprint $table) {
            $table->foreignId('id_prodi')->nullable(false)->change();
            $table->enum('status_kepegawaian', ['PNS', 'Honorer', 'Kontrak'])->default('Honorer')->change();
            
            $table->dropColumn([
                'jabatan_struktural',
                'file_ktp', 'file_ijazah_s1', 'file_transkrip_s1',
                'file_ijazah_s2', 'file_transkrip_s2', 
                'file_ijazah_s3', 'file_transkrip_s3',
                'file_kk', 'file_perjanjian_kerja', 'file_sk', 'file_surat_tugas'
            ]);
        });
    }
};