<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->unsignedBigInteger('id_prodi');
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nik')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('tmt_kerja')->nullable();
            $table->integer('masa_kerja_tahun')->nullable();
            $table->integer('masa_kerja_bulan')->nullable();
            $table->string('golongan')->nullable();
            $table->integer('masa_kerja_golongan_tahun')->nullable();
            $table->integer('masa_kerja_golongan_bulan')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();

            $table->foreign('id_prodi')->references('id_prodi')->on('prodi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
    