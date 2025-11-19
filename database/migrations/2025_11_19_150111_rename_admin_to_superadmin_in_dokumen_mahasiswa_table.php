<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dokumen_mahasiswa', function (Blueprint $table) {
            // Jika column admin_verifikator_id sudah ada, rename
            if (Schema::hasColumn('dokumen_mahasiswa', 'admin_verifikator_id')) {
                $table->renameColumn('admin_verifikator_id', 'superadmin_verifikator_id');
            } else {
                // Jika belum ada, tambahkan
                $table->foreignId('superadmin_verifikator_id')->nullable()->constrained('users');
            }
        });
    }

    public function down()
    {
        Schema::table('dokumen_mahasiswa', function (Blueprint $table) {
            $table->renameColumn('superadmin_verifikator_id', 'admin_verifikator_id');
        });
    }
};