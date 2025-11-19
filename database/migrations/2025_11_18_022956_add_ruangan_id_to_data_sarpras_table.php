<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_sarpras', function (Blueprint $table) {
            if (!Schema::hasColumn('data_sarpras', 'ruangan_id')) {
                $table->unsignedBigInteger('ruangan_id')->nullable()->after('id_prodi');
                $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_sarpras', function (Blueprint $table) {
            if (Schema::hasColumn('data_sarpras', 'ruangan_id')) {
                $table->dropForeign(['ruangan_id']);
                $table->dropColumn('ruangan_id');
            }
        });
    }
};