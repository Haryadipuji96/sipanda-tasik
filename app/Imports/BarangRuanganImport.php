<?php

namespace App\Imports;

use App\Models\DataSarpras;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BarangRuanganImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $ruanganId;

    public function __construct($ruanganId)
    {
        $this->ruanganId = $ruanganId;
    }

    public function model(array $row)
    {
        // Skip jika row kosong atau header
        if (empty($row['nama_barang']) || $row['nama_barang'] === 'NAMA BARANG*') {
            return null;
        }

        return new DataSarpras([
            'nama_barang' => $row['nama_barang'],
            'kategori_barang' => $row['kategori_barang'],
            'merk_barang' => $row['merk_barang'] ?? null,
            'harga' => $this->cleanNumber($row['harga_rp'] ?? null),
            'jumlah' => (int) $row['jumlah'],
            'satuan' => $row['satuan'],
            'kondisi' => $row['kondisi'],
            'tanggal_pengadaan' => $this->cleanDate($row['tanggal_pengadaan'] ?? null),
            'tahun' => $row['tahun_pengadaan'] ? (int) $row['tahun_pengadaan'] : null,
            'sumber' => $row['sumber_barang'],
            'spesifikasi' => $row['spesifikasi'],
            'kode_seri' => $row['kodeseri_barang'],
            'lokasi_lain' => $row['lokasi_lain'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
            'ruangan_id' => $this->ruanganId,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required|string|max:255',
            'kategori_barang' => 'required|in:PERABOTAN & FURNITURE,ELEKTRONIK & TEKNOLOGI,PERALATAN LABORATORIUM,PERALATAN KANTOR,ALAT KOMUNIKASI,LAINNYA',
            'merk_barang' => 'nullable|string|max:100',
            'harga_rp' => 'nullable|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|in:unit,buah,set,lusin,paket',
            'kondisi' => 'required|in:Baik Sekali,Baik,Cukup,Rusak Ringan,Rusak Berat',
            'tanggal_pengadaan' => 'nullable|date',
            'tahun_pengadaan' => 'nullable|integer|min:2000|max:' . date('Y'),
            'sumber_barang' => 'required|in:HIBAH,LEMBAGA,YAYASAN',
            'spesifikasi' => 'required|string|max:1000',
            'kodeseri_barang' => 'required|string|max:100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_barang.required' => 'Nama barang harus diisi',
            'kategori_barang.required' => 'Kategori barang harus diisi',
            'kategori_barang.in' => 'Kategori barang harus: PERABOTAN & FURNITURE, ELEKTRONIK & TEKNOLOGI, PERALATAN LABORATORIUM, PERALATAN KANTOR, ALAT KOMUNIKASI, atau LAINNYA',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.min' => 'Jumlah minimal 1',
            'satuan.required' => 'Satuan harus diisi',
            'satuan.in' => 'Satuan harus: unit, buah, set, lusin, atau paket',
            'kondisi.required' => 'Kondisi harus diisi',
            'kondisi.in' => 'Kondisi harus: Baik Sekali, Baik, Cukup, Rusak Ringan, atau Rusak Berat',
            'sumber_barang.required' => 'Sumber barang harus diisi',
            'sumber_barang.in' => 'Sumber barang harus: HIBAH, LEMBAGA, atau YAYASAN',
            'spesifikasi.required' => 'Spesifikasi harus diisi',
            'kodeseri_barang.required' => 'Kode/seri barang harus diisi',
            'tahun_pengadaan.max' => 'Tahun pengadaan maksimal ' . date('Y'),
        ];
    }

    private function cleanNumber($value)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        if (is_string($value)) {
            // Handle format Indonesia: 300.000 -> 300000
            $cleaned = preg_replace('/[^0-9,.-]/', '', $value);
            $cleaned = str_replace('.', '', $cleaned);
            $cleaned = str_replace(',', '.', $cleaned);
            
            return $cleaned ? (float) $cleaned : null;
        }

        return (float) $value;
    }

    private function cleanDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Handle format DD/MM/YYYY
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
            $day = $matches[1];
            $month = $matches[2];
            $year = $matches[3];
            return "{$year}-{$month}-{$day}";
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}