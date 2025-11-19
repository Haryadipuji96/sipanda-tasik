<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prodi')->nullable(); // null untuk ruangan umum
            $table->string('nama_ruangan'); // Contoh: "Kelas 1A", "Lab Komputer"
            $table->enum('kategori', ['ruang_kelas', 'laboratorium', 'kantor', 'perpustakaan', 'aula', 'lainnya']);
            $table->string('kondisi_ruangan'); // Baik, Rusak Ringan, Rusak Berat
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};