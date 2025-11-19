<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSarpras extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_prodi',
        'ruangan_id', // Ubah dari 'ruangan_id' menjadi 'id_ruangan' untuk konsistensi
        'nama_ruangan',
        'nama_barang',
        'merk_barang',
        'jumlah',
        'satuan',
        'kategori_barang',
        'kondisi',
        'tanggal_pengadaan',
        'spesifikasi',
        'kode_seri',
        'sumber',
        'keterangan',
        'file_dokumen',
        'lokasi_lain',
        'harga', 
    ];

    protected $casts = [
        'tanggal_pengadaan' => 'date',
        'jumlah' => 'integer'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id'); // Sesuaikan dengan kolom di database
    }
}