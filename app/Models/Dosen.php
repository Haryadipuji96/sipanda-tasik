<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'id_prodi',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'pendidikan_terakhir',
        'jabatan',
        'tmt_kerja',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'golongan',
        'masa_kerja_golongan_tahun',
        'masa_kerja_golongan_bulan',
        'file_dokumen',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }
}
