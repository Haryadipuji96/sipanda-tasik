<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_sarpras', function (Blueprint $table) {
            // Tambah kolom baru
            if (!Schema::hasColumn('data_sarpras', 'nama_ruangan')) {
                $table->string('nama_ruangan', 255)->after('id_prodi')->default('Ruangan Default');
            }
            
            if (!Schema::hasColumn('data_sarpras', 'kategori_ruangan')) {
                $table->string('kategori_ruangan', 100)->after('nama_ruangan')->default('ruang_kelas');
            }
            
            if (!Schema::hasColumn('data_sarpras', 'merk_barang')) {
                $table->string('merk_barang', 100)->nullable()->after('nama_barang');
            }
            
            if (!Schema::hasColumn('data_sarpras', 'satuan')) {
                $table->string('satuan', 50)->default('unit')->after('jumlah');
            }
            
            if (!Schema::hasColumn('data_sarpras', 'kategori_barang')) {
                $table->string('kategori_barang', 100)->after('satuan')->default('Umum');
            }
            
            // Hapus kolom lama 'kategori' karena diganti dengan 'kategori_barang'
            if (Schema::hasColumn('data_sarpras', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_sarpras', function (Blueprint $table) {
            // Kembalikan kolom lama
            if (!Schema::hasColumn('data_sarpras', 'kategori')) {
                $table->string('kategori', 100)->default('Umum');
            }
            
            // Hapus kolom baru
            $columnsToDrop = ['nama_ruangan', 'kategori_ruangan', 'merk_barang', 'satuan', 'kategori_barang'];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('data_sarpras', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};