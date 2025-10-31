<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaPendidik extends Model
{
    use HasFactory;

    protected $table = 'tenaga_pendidik';
    protected $primaryKey = 'id_tenaga_pendidik';

    // Semua kolom yang bisa diisi massal
    protected $fillable = [
        'id_prodi',
        'nama_tendik',
        'nip',
        'jabatan',
        'status_kepegawaian',
        'pendidikan_terakhir',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'keterangan',
        'file',
    ];

    // Cast enum ke string secara otomatis
    protected $casts = [
        'status_kepegawaian' => 'string',
        'jenis_kelamin' => 'string',
    ];

    // Relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    // Accessor untuk menampilkan path file lengkap
    public function getFileUrlAttribute()
    {
        return $this->file ? asset('storage/'.$this->file) : null;
    }
}
