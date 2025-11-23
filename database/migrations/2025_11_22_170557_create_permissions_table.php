<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('menu_key')->unique();
            $table->timestamps();
        });

        // Insert default permissions
        DB::table('permissions')->insert([
            [
                'name' => 'Manage Dosen',
                'description' => 'Mengelola data dosen',
                'menu_key' => 'dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manage Tenaga Pendidik',
                'description' => 'Mengelola data tenaga pendidik',
                'menu_key' => 'tenaga-pendidik',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Manage Sarpras',
                'description' => 'Mengelola data ruangan',
                'menu_key' => 'ruangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manage Arsip',
                'description' => 'Mengelola data arsip',
                'menu_key' => 'arsip',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manage Fakultas',
                'description' => 'Mengelola data fakultas',
                'menu_key' => 'fakultas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manage Prodi',
                'description' => 'Mengelola data program studi',
                'menu_key' => 'prodi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manage Users',
                'description' => 'Mengelola data pengguna',
                'menu_key' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'View Log Aktivitas',
                'description' => 'Melihat log aktivitas pengguna',
                'menu_key' => 'userlogin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};