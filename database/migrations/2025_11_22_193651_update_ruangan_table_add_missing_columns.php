<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ruangan', function (Blueprint $table) {
            // Hapus kolom kategori yang lama (jika ada)
            if (Schema::hasColumn('ruangan', 'kategori')) {
                $table->dropColumn('kategori');
            }
            
            // Tambah kolom baru sesuai kebutuhan
            if (!Schema::hasColumn('ruangan', 'tipe_ruangan')) {
                $table->enum('tipe_ruangan', ['sarana', 'prasarana'])->default('sarana')->after('id_prodi');
            }
            
            if (!Schema::hasColumn('ruangan', 'unit_prasarana')) {
                $table->string('unit_prasarana')->nullable()->after('tipe_ruangan');
            }
            
            if (!Schema::hasColumn('ruangan', 'kapasitas')) {
                $table->integer('kapasitas')->nullable()->after('unit_prasarana');
            }
            
            if (!Schema::hasColumn('ruangan', 'fasilitas')) {
                $table->text('fasilitas')->nullable()->after('kapasitas');
            }
        });
    }

    public function down()
    {
        Schema::table('ruangan', function (Blueprint $table) {
            // Kembalikan ke state semula
            $table->dropColumn(['tipe_ruangan', 'unit_prasarana', 'kapasitas', 'fasilitas']);
            
            // Tambah kembali kolom kategori jika diperlukan
            if (!Schema::hasColumn('ruangan', 'kategori')) {
                $table->enum('kategori', ['ruang_kelas', 'laboratorium', 'kantor', 'perpustakaan', 'aula', 'lainnya'])->nullable();
            }
        });
    }
};