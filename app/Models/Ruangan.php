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
        'tipe_ruangan',  // tambahkan
        'unit_umum',     // tambahkan  
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

    public function sarpras()
    {
        return $this->hasMany(DataSarpras::class, 'ruangan_id');
    }

    // Scope untuk filter tipe ruangan
    public function scopeAkademik($query)
    {
        return $query->where('tipe_ruangan', 'akademik');
    }

    public function scopeUmum($query)
    {
        return $query->where('tipe_ruangan', 'umum');
    }
}