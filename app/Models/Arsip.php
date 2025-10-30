<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    protected $primaryKey = 'id_arsip';
    protected $fillable = [
        'id_kategori',
        'id_prodi',
        'id_dosen',
        'judul_dokumen',
        'nomor_dokumen',
        'tanggal_dokumen',
        'tahun',
        'file_dokumen',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriArsip::class, 'id_kategori');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }
}
