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

    // Relasi ke ruangan
    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'id_prodi');
    }

    // Relasi ke sarpras
    public function sarpras()
    {
        return $this->hasMany(DataSarpras::class, 'id_prodi');
    }

    
}