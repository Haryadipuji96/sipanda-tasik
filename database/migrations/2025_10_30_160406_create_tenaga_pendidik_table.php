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
            $table->foreignId('id_prodi')->constrained('prodi')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_tendik');
            $table->string('nip')->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('status_kepegawaian',['PNS','Honorer','Kontrak']);
            $table->string('pendidikan_terakhir')->nullable();
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->string('no_hp')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('alamat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenaga_pendidik');
    }
};
