<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_prodi')->nullable();
            $table->string('judul_dokumen');
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('tahun')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Relasi ke master
            $table->foreign('id_kategori')->references('id')->on('kategori_arsip')->onDelete('cascade');
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
