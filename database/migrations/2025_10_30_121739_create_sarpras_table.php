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
            $table->unsignedBigInteger('ruangan_id')->nullable();
            $table->string('nama_ruangan', 255)->default('Ruangan Default');
            $table->string('kategori_ruangan', 100)->default('ruang_kelas');
            $table->string('nama_barang', 255);
            $table->string('merk_barang', 100)->nullable();
            $table->integer('jumlah');
            $table->string('satuan', 50)->default('unit');
            $table->decimal('harga', 15, 2)->nullable();
            $table->string('kategori_barang', 100)->default('Umum');
            $table->string('kondisi', 50);
            $table->date('tanggal_pengadaan')->nullable();
            $table->year('tahun')->nullable();
            $table->text('spesifikasi');
            $table->string('kode_seri', 100);
            $table->enum('sumber', ['HIBAH', 'LEMBAGA', 'YAYASAN']);
            $table->string('keterangan', 255)->nullable();
            $table->string('file_dokumen', 255)->nullable();
            $table->string('lokasi_lain', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
            // ❌ COMMENT/HAPUS SEMENTARA foreign key ke ruangan
            // $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_sarpras');
    }
};