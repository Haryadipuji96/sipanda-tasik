<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenaga_pendidik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_prodi')->nullable()->constrained('prodi')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_tendik');
            $table->string('nip')->nullable();
            $table->string('status_kepegawaian', 50)->nullable(); // Changed to string based on database
            $table->string('pendidikan_terakhir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('no_hp')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('alamat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tmt_kerja')->nullable();
            $table->text('golongan_history')->nullable();
            $table->string('file')->nullable();
            
            // Kolom tambahan dari migration kedua
            $table->string('jabatan_struktural')->nullable();
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
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenaga_pendidik');
    }
};