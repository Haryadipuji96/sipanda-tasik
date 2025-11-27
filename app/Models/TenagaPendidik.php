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
        'jabatan_struktural',
        'pendidikan_terakhir',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'keterangan',
        'file',
        'file_ktp',
        'file_ijazah_s1',
        'file_transkrip_s1',
        'file_ijazah_s2',
        'file_transkrip_s2',
        'file_ijazah_s3', // ✅ DITAMBAHKAN
        'file_transkrip_s3', // ✅ DITAMBAHKAN
        'file_kk',
        'file_perjanjian_kerja',
        'file_sk',
        'file_surat_tugas',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tmt_kerja' => 'date',
        'golongan_history' => 'array',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    public function getNamaLengkapAttribute(): string
    {
        $nama = [];
        if ($this->gelar_depan) $nama[] = $this->gelar_depan;
        $nama[] = $this->nama_tendik;
        if ($this->gelar_belakang) $nama[] = $this->gelar_belakang;
        return implode(' ', $nama);
    }

    public static function getJabatanStrukturalOptions(): array
    {
        return [
            'Rektor IAIT',
            'Wakil Rektor Bid. Akademik',
            'Wakil Rektor Bid. Adm. & Umum',
            'Wakil Rektor Bid. Kemahasiswaan, Alumni & Kerjasama',
            'Kepala SPI',
            'Dekan Fakultas Tarbiyah',
            'Plt. Dekan Fakultas Syariah & Hukum',
            'Dekan Fakultas Ekonomi & Bisnis Islam',
            'Direktur Pascasarjana',
            'Kepala Biro',
            'Kepala Bagian Akademik & Kemahasiswaan, Ketatausahaan, Kerjasama & Hubungan Masyarakat',
            'Kepala Bagian Umum (Sarana Prasarana, Organisasi, Hukum, Kepegawaian)',
            'Kepala Bagian Keuangan & Perencanaan',
            'Kepala Sub. Bagian Akademik',
            'Plt. Kepala Sub. Bagian Kemahasiswaan',
            'Kepala Sub. Bagian Organisasi, Hukum, Kepegawaian',
            'Plt. Kepala Sub. Bagian Ketatausahaan, Kerjasama & Hubungan Masyarakat',
            'Kepala Sub. Bagian Sarana Prasarana',
            'Kepala Sub. Bagian Keuangan',
            'Ketua Prodi PAI',
            'Plt. Sekretaris Prodi PAI',
            'Ketua Prodi HKI',
            'Ketua Prodi EKSYAR',
            'Ketua Prodi PGMI',
            'Ketua Prodi MPI',
            'Ketua Prodi HTN',
            'Ketua Prodi PIAUD',
            'Ketua Prodi PAI Pascasarjana',
            'Ketua Prodi BKPI',
            'Kepala Lembaga Penelitian & Pengabdian kepada Masyarakat (LPPM)',
            'Kepala Lembaga Penjaminan Mutu',
            'Plt. Kepala Perpustakaan & Kearsipan',
            'Sekretaris Perpustakaan & Kearsipan',
            'Kepala Pusat Pengembangan Bahasa',
            'Sekretaris Pusat Pengembangan Bahasa',
            'Plt. Kepala Pusat Teknologi & Informasi',
        ];
    }

    public function getGolonganArrayAttribute(): array
    {
        if (empty($this->golongan_history)) {
            return [];
        }

        if (is_array($this->golongan_history)) {
            return $this->golongan_history;
        }

        $decoded = json_decode($this->golongan_history, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function getGolonganTerakhirAttribute(): string
    {
        $history = $this->golongan_array;
        if (empty($history)) {
            return '-';
        }

        $last = end($history);
        return ($last['golongan'] ?? '-') . ' (' . ($last['tahun'] ?? '-') . ')';
    }

    public function getTempatTanggalLahirAttribute(): string
    {
        if ($this->tempat_lahir && $this->tanggal_lahir) {
            return $this->tempat_lahir . ', ' . $this->tanggal_lahir->format('d/m/Y');
        }
        return $this->tempat_lahir ?? '-';
    }

    public function getStatusKepegawaianLabelAttribute(): string
    {
        return $this->status_kepegawaian ?? '-';
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin ? ucfirst($this->jenis_kelamin) : '-';
    }
}