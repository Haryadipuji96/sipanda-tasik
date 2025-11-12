<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('gelar_depan')->nullable()->after('id_prodi');
            $table->string('gelar_belakang')->nullable()->after('nama');
            $table->string('nuptk')->nullable()->after('nik');
            
            // Kolom file upload baru
            $table->string('file_sertifikasi')->nullable();
            $table->string('file_inpasing')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ijazah_s1')->nullable();
            $table->string('file_transkrip_s1')->nullable();
            $table->string('file_ijazah_s2')->nullable();
            $table->string('file_transkrip_s2')->nullable();
            $table->string('file_ijazah_s3')->nullable();
            $table->string('file_transkrip_s3')->nullable();
            $table->string('file_jafung')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_perjanjian_kerja')->nullable();
            $table->string('file_sk_pengangkatan')->nullable();
            $table->string('file_surat_pernyataan')->nullable();
            $table->string('file_sktp')->nullable();
            $table->string('file_surat_tugas')->nullable();
            $table->string('file_sk_aktif')->nullable();
        });
    }

    public function down()
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropColumn([
                'gelar_depan',
                'gelar_belakang', 
                'nuptk',
                'file_sertifikasi',
                'file_inpasing',
                'file_ktp',
                'file_ijazah_s1',
                'file_transkrip_s1',
                'file_ijazah_s2',
                'file_transkrip_s2',
                'file_ijazah_s3',
                'file_transkrip_s3',
                'file_jafung',
                'file_kk',
                'file_perjanjian_kerja',
                'file_sk_pengangkatan',
                'file_surat_pernyataan',
                'file_sktp',
                'file_surat_tugas',
                'file_sk_aktif'
            ]);
        });
    }
};