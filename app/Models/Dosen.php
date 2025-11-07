<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_prodi',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'pendidikan_terakhir',
        'pendidikan_data',
        'jabatan',
        'tmt_kerja',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'golongan',
        'pangkat_golongan',
        'jabatan_fungsional',
        'masa_kerja_golongan_tahun',
        'masa_kerja_golongan_bulan',
        'no_sk',
        'no_sk_jafung',
        'file_dokumen',
        'sertifikasi',
        'inpasing',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    // Helper untuk decode pendidikan JSON
    public function getPendidikanArrayAttribute()
    {
        return $this->pendidikan_data ? json_decode($this->pendidikan_data, true) : [];
    }

    // Helper untuk format tempat tanggal lahir
    public function getTempatTanggalLahirAttribute()
    {
        if ($this->tempat_lahir && $this->tanggal_lahir) {
            return $this->tempat_lahir . ', ' . $this->tanggal_lahir->format('d/m/Y');
        }
        return $this->tempat_lahir ?? '-';
    }
}