<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ruangan', function (Blueprint $table) {
            $table->enum('tipe_ruangan', ['akademik', 'umum'])->default('akademik')->after('id_prodi');
            $table->string('unit_umum')->nullable()->after('tipe_ruangan');
            
            // Ubah id_prodi jadi nullable karena ruangan umum tidak punya prodi
            $table->unsignedBigInteger('id_prodi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('ruangan', function (Blueprint $table) {
            $table->dropColumn(['tipe_ruangan', 'unit_umum']);
            $table->unsignedBigInteger('id_prodi')->nullable(false)->change();
        });
    }
};