<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_fakultas',
        'nama_prodi',
        'jenjang',
        'ketua_prodi',
        'deskripsi',
    ];

    // Relasi ke fakultas
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }

    // Relasi one-to-many ke ruangan (untuk backward compatibility)
    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_prodi');
    }

    // ✅ RELASI BARU: Many-to-many dengan ruangan
    public function ruangans()
    {
        return $this->belongsToMany(Ruangan::class, 'ruangan_prodi', 'prodi_id', 'ruangan_id');
    }

    // Relasi ke sarpras
    public function sarpras()
    {
        return $this->hasMany(DataSarpras::class, 'id_prodi');
    }

    // ✅ RELASI BARU: Relasi ke dosen sebagai ketua prodi
    public function ketuaProdi()
    {
        return $this->belongsTo(Dosen::class, 'ketua_prodi', 'id');
    }

    // ✅ RELASI BARU: Relasi ke semua dosen di prodi ini
    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'id_prodi');
    }

    public function dokumenMahasiswa()
    {
        return $this->hasMany(DokumenMahasiswa::class, 'prodi_id');
    }
}