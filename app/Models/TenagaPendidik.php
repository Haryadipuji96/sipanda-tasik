<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaPendidik extends Model
{
    use HasFactory;

    protected $table = 'tenaga_pendidik';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_prodi',
        'nama_tendik',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'tmt_kerja',
        'golongan_history',
        'nip',
        'status_kepegawaian',
        'pendidikan_terakhir',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'keterangan',
        'file',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt_kerja' => 'date',
        'golongan_history' => 'array', // otomatis decode JSON
    ];

    // Relasi ke tabel prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    // Nama lengkap dengan gelar
    public function getNamaLengkapAttribute()
    {
        $nama = [];
        if ($this->gelar_depan) $nama[] = $this->gelar_depan;
        $nama[] = $this->nama_tendik;
        if ($this->gelar_belakang) $nama[] = $this->gelar_belakang;
        return implode(' ', $nama);
    }

    // Ambil golongan sebagai array
    public function getGolonganArrayAttribute()
    {
        return is_array($this->golongan_history) ? $this->golongan_history : json_decode($this->golongan_history, true) ?? [];
    }

    // Golongan terakhir
    public function getGolonganTerakhirAttribute()
    {
        $history = $this->golongan_array;
        if (empty($history)) {
            return '-';
        }

        $last = end($history);
        return ($last['golongan'] ?? '-') . ' (' . ($last['tahun'] ?? '-') . ')';
    }

    // Tempat & Tanggal Lahir
    public function getTempatTanggalLahirAttribute()
    {
        if ($this->tempat_lahir && $this->tanggal_lahir) {
            return $this->tempat_lahir . ', ' . $this->tanggal_lahir->format('d/m/Y');
        }
        return $this->tempat_lahir ?? '-';
    }

    // Status label (untuk status_kepegawaian)
    public function getStatusKepegawaianLabelAttribute()
    {
        return $this->status_kepegawaian ?? '-';
    }

    // Jenis kelamin label
    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin ? ucfirst($this->jenis_kelamin) : '-';
    }
}
