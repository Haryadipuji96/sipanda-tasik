<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    
    protected $fillable = [
        'id_prodi',
        'tipe_ruangan',  // sekarang: sarana/prasarana
        'unit_prasarana', // renamed dari unit_umum
        'nama_ruangan', 
        'kondisi_ruangan',
        'kapasitas',
        'fasilitas'
    ];

    protected $casts = [
        'tipe_ruangan' => 'string'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function fakultas()
    {
        return $this->hasOneThrough(Fakultas::class, Prodi::class, 'id', 'id', 'id_prodi', 'id_fakultas');
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function sarpras()
    {
        return $this->hasMany(DataSarpras::class, 'ruangan_id');
    }

    // TAMBAHKAN INI - Relasi barang sebagai alias untuk sarpras
    public function barang()
    {
        return $this->hasMany(DataSarpras::class, 'ruangan_id');
    }

    // Scope untuk filter tipe ruangan
    public function scopeSarana($query)
    {
        return $query->where('tipe_ruangan', 'sarana');
    }

    public function scopePrasarana($query)
    {
        return $query->where('tipe_ruangan', 'prasarana');
    }
}