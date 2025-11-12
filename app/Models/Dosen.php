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
        'gelar_depan',
        'nama',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'nuptk',
        'pendidikan_terakhir',
        'pendidikan_data',
        'jabatan',
        'tmt_kerja',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'pangkat_golongan',
        'jabatan_fungsional',
        'masa_kerja_golongan_tahun',
        'masa_kerja_golongan_bulan',
        'no_sk',
        'no_sk_jafung',
        'file_dokumen',
        'sertifikasi',
        'inpasing',
        // File upload baru
        'file_sertifikasi',
        'file_inpasing',
        'file_ktp',
        'file_ijazah_s1',
        'file_transkrip_s1',
        'file_ijazah_s2',
        'file_transkrip_s2',
        'file_ijazah_s3',
        'file_transkrip_s3',
        'file_jafung',
        'file_kk',
        'file_perjanjian_kerja',
        'file_sk_pengangkatan',
        'file_surat_pernyataan',
        'file_sktp',
        'file_surat_tugas',
        'file_sk_aktif',
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

    // Helper untuk nama lengkap dengan gelar
    public function getNamaLengkapAttribute()
    {
        $nama = $this->nama;
        if ($this->gelar_depan) {
            $nama = $this->gelar_depan . ' ' . $nama;
        }
        if ($this->gelar_belakang) {
            $nama = $nama . ', ' . $this->gelar_belakang;
        }
        return $nama;
    }
}