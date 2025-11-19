<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';
    protected $fillable = ['nama_fakultas', 'dekan', 'deskripsi'];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'id_fakultas');
    }

    public function ruangan()
    {
        return $this->hasManyThrough(Ruangan::class, Prodi::class, 'id_fakultas', 'id_prodi');
    }
}