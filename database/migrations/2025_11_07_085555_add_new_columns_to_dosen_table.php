<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->string('pangkat_golongan')->nullable();
            $table->string('jabatan_fungsional')->nullable()->after('pangkat_golongan');
            $table->string('no_sk')->nullable()->after('jabatan_fungsional');
            $table->string('no_sk_jafung')->nullable()->after('no_sk');
            $table->text('pendidikan_data')->nullable()->after('pendidikan_terakhir');
            $table->enum('sertifikasi', ['SUDAH', 'BELUM'])->default('BELUM')->after('file_dokumen');
            $table->enum('inpasing', ['SUDAH', 'BELUM'])->default('BELUM')->after('sertifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropColumn([
                'pangkat_golongan',
                'jabatan_fungsional',
                'no_sk',
                'no_sk_jafung',
                'pendidikan_data',
                'sertifikasi',
                'inpasing'
            ]);
        });
    }
};
