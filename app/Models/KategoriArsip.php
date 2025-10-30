<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriArsip extends Model
{
    use HasFactory;

    protected $table = 'kategori_arsip';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori', 'deskripsi'];

    // Relasi ke arsip (nanti dipakai di tabel arsip)
    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'id_kategori');
    }
}
