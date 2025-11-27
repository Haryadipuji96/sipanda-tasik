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
        'tmt_kerja', // ✅ varchar di database, tetap string
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'pangkat_golongan',
        'jabatan_fungsional',
        'golongan', // ✅ DITAMBAHKAN
        'masa_kerja_golongan_tahun',
        'masa_kerja_golongan_bulan',
        'no_sk',
        'no_sk_jafung',
        'file_dokumen',
        'sertifikasi',
        'inpasing',
        'status_dosen',
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

    public static function getStatusDosenOptions()
    {
        return [
            'DOSEN_TETAP' => 'Dosen Tetap',
            'DOSEN_TIDAK_TETAP' => 'Dosen Tidak Tetap',
            'PNS' => 'PNS',
        ];
    }

    protected $casts = [
        'tanggal_lahir' => 'date',
        // ❌ 'tmt_kerja' => 'date', // DIHAPUS karena di database varchar
    ];

    protected $attributes = [
        'status_dosen' => 'DOSEN_TETAP',
    ];

    public function getStatusDosenTextAttribute()
    {
        return self::getStatusDosenOptions()[$this->status_dosen] ?? $this->status_dosen;
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    public function prodiKetua()
    {
        return $this->hasOne(Prodi::class, 'ketua_prodi', 'id');
    }

    public function getPendidikanArrayAttribute()
    {
        return $this->pendidikan_data ? json_decode($this->pendidikan_data, true) : [];
    }

    public function getTempatTanggalLahirAttribute()
    {
        $tempat = $this->tempat_lahir;
        $tanggal = $this->tanggal_lahir ? $this->tanggal_lahir->format('d-m-Y') : '';
        
        if ($tempat && $tanggal) {
            return $tempat . ', ' . $tanggal;
        } elseif ($tempat) {
            return $tempat;
        } elseif ($tanggal) {
            return $tanggal;
        }
        
        return '-';
    }

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

    public function getIsKetuaProdiAttribute()
    {
        return $this->prodiKetua()->exists();
    }
}