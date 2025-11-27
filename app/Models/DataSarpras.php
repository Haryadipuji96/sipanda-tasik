<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSarpras extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_prodi',
        'ruangan_id',
        'nama_ruangan',
        'nama_barang',
        'merk_barang',
        'jumlah',
        'satuan',
        'harga', 
        'kategori_barang',
        'kondisi',
        'tanggal_pengadaan',
        'tahun', // ✅ DITAMBAHKAN
        'spesifikasi',
        'kode_seri',
        'sumber',
        'keterangan',
        'file_dokumen',
        'lokasi_lain',
    ];

    protected $casts = [
        'tanggal_pengadaan' => 'date',
        'tahun' => 'integer',
        'jumlah' => 'integer',
        'harga' => 'decimal:2', // ✅ DITAMBAHKAN
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}