<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ruangan_prodi', function (Blueprint $table) {
            $table->id();
            
            // PERBAIKAN: Tentukan nama tabel secara eksplisit
            $table->foreignId('ruangan_id')
                  ->constrained('ruangan') // <- TAMBAHKAN 'ruangan' di sini
                  ->onDelete('cascade');
                  
            $table->foreignId('prodi_id')
                  ->constrained('prodi') // <- Bisa juga tambahkan 'prodi' untuk jelas
                  ->onDelete('cascade');
                  
            $table->timestamps();
            
            $table->unique(['ruangan_id', 'prodi_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruangan_prodi');
    }
};