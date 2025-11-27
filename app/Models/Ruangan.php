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
        'kapasitas', // ✅ DITAMBAHKAN
        'fasilitas', // ✅ DITAMBAHKAN
        'nama_ruangan', 
        'kondisi_ruangan',
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
}