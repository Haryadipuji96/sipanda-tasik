<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'dokumen_mahasiswa';
    
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'prodi_id',
        'tahun_masuk',
        'tahun_keluar',
        'status_mahasiswa',
        'file_ijazah',
        'file_transkrip',
    ];

    protected $casts = [
        'tahun_masuk' => 'integer',
        'tahun_keluar' => 'integer',
    ];

    // Relasi ke prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    // // Relasi ke superadmin yang memverifikasi
    // public function superadminVerifikator()
    // {
    //     return $this->belongsTo(User::class, 'superadmin_verifikator_id');
    // }

    // // Scope untuk filter status
    // public function scopeTerverifikasi($query)
    // {
    //     return $query->where('status_verifikasi', 'Terverifikasi');
    // }

    // public function scopeMenunggu($query)
    // {
    //     return $query->where('status_verifikasi', 'Menunggu');
    // }

    // public function scopeDitolak($query)
    // {
    //     return $query->where('status_verifikasi', 'Ditolak');
    // }

    // Scope untuk status mahasiswa
    public function scopeAktif($query)
    {
        return $query->where('status_mahasiswa', 'Aktif');
    }

    public function scopeLulus($query)
    {
        return $query->where('status_mahasiswa', 'Lulus');
    }
}