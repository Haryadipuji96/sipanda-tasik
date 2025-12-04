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
        'tipe_ruangan',
        'unit_prasarana',
        'kapasitas',
        'fasilitas',
        'nama_ruangan', 
        'kondisi_ruangan',
        'file_dokumen', // Tambahkan jika belum ada
    ];

    protected $casts = [
        'tipe_ruangan' => 'string'
    ];

    // Relasi one-to-many (untuk backward compatibility)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    // ✅ RELASI BARU: Many-to-many dengan prodi
    public function prodis()
    {
        return $this->belongsToMany(Prodi::class, 'ruangan_prodi', 'ruangan_id', 'prodi_id');
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

    public function barang()
    {
        return $this->hasMany(DataSarpras::class, 'ruangan_id');
    }

    public function scopeSarana($query)
    {
        return $query->where('tipe_ruangan', 'sarana');
    }

    public function scopePrasarana($query)
    {
        return $query->where('tipe_ruangan', 'prasarana');
    }
    
    // ✅ METHOD BARU: Cek apakah ruangan digunakan bersama
    public function isDigunakanBersama()
    {
        return $this->prodis()->count() > 1;
    }
}