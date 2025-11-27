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
            $table->enum('tipe_ruangan', ['sarana', 'prasarana'])->default('sarana');
            $table->string('unit_prasarana')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->text('fasilitas')->nullable();
            $table->string('nama_ruangan');
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