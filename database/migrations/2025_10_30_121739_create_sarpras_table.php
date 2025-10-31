<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_sarpras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prodi')->nullable();
            $table->string('nama_barang', 255);
            $table->string('kategori', 100);
            $table->integer('jumlah');
            $table->string('kondisi', 50);
            $table->date('tanggal_pengadaan');
            $table->text('spesifikasi');
            $table->string('kode_seri', 100);
            $table->enum('sumber', ['HIBAH', 'LEMBAGA', 'YAYASAN']);
            $table->string('keterangan', 255)->nullable();
            $table->string('file_dokumen', 255)->nullable();
            $table->string('lokasi_lain', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_sarpras');
    }
};
