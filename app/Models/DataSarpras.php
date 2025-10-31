<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSarpras extends Model
{
    use HasFactory;

    protected $table = 'data_sarpras';
    protected $primaryKey = 'id_data_sarpras';

    protected $fillable = [
        'id_prodi',
        'nama_barang',
        'kategori',
        'jumlah',
        'kondisi',
        'tanggal_pengadaan',
        'spesifikasi',
        'kode_seri',
        'sumber',
        'keterangan',
        'file_dokumen',
        'lokasi_lain',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }
}
