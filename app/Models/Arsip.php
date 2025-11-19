<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kategori',
        'judul_dokumen',
        'nomor_dokumen',
        'tanggal_dokumen',
        'tahun',
        'file_dokumen',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriArsip::class, 'id_kategori', 'id');
    }

}
