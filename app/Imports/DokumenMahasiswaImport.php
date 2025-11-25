<?php

namespace App\Imports;

use App\Models\DokumenMahasiswa;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class DokumenMahasiswaImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $prodiCache = [];

    public function model(array $row)
    {
        // Skip jika row kosong atau header
        if (empty($row['nim']) || $row['nim'] === 'nim*') {
            return null;
        }

        // Convert NIM to string
        $nim = $this->formatNim($row['nim']);
        
        // Cari ID prodi berdasarkan nama (dari dropdown, pasti valid)
        $prodiId = $this->findProdiId($row['program_studi']);
        
        if (!$prodiId) {
            throw new \Exception("Program Studi '{$row['program_studi']}' tidak ditemukan");
        }

        return new DokumenMahasiswa([
            'nim' => $nim,
            'nama_lengkap' => $row['nama_lengkap'],
            'prodi_id' => $prodiId,
            'status_mahasiswa' => $row['status_mahasiswa'],
            'tahun_masuk' => $row['tahun_masuk'],
            'tahun_keluar' => $this->handleTahunKeluar($row['tahun_keluar'] ?? null, $row['status_mahasiswa']),
        ]);
    }

    public function rules(): array
    {
        $currentYear = date('Y');
        
        return [
            'nim' => 'required|max:20|unique:dokumen_mahasiswa,nim',
            'nama_lengkap' => 'required|string|max:255',
            'program_studi' => 'required',
            'status_mahasiswa' => 'required|in:Aktif,Lulus,Cuti,Drop Out',
            'tahun_masuk' => 'required|integer|min:2000|max:' . ($currentYear + 1),
            'tahun_keluar' => 'nullable|integer|min:2000|max:' . ($currentYear + 1),
        ];
    }

    public function customValidationMessages()
    {
        $currentYear = date('Y');
        
        return [
            'nim.required' => 'NIM harus diisi',
            'nim.unique' => 'NIM sudah digunakan',
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'program_studi.required' => 'Program Studi harus diisi',
            'status_mahasiswa.required' => 'Status mahasiswa harus diisi',
            'status_mahasiswa.in' => 'Status mahasiswa harus: Aktif, Lulus, Cuti, atau Drop Out',
            'tahun_masuk.required' => 'Tahun masuk harus diisi',
            'tahun_masuk.integer' => 'Tahun masuk harus angka',
            'tahun_masuk.min' => 'Tahun masuk minimal 2000',
            'tahun_masuk.max' => 'Tahun masuk maksimal ' . ($currentYear + 1),
            'tahun_keluar.integer' => 'Tahun keluar harus angka',
            'tahun_keluar.min' => 'Tahun keluar minimal 2000',
            'tahun_keluar.max' => 'Tahun keluar maksimal ' . ($currentYear + 1),
        ];
    }

    private function findProdiId($prodiName)
    {
        if (!isset($this->prodiCache[$prodiName])) {
            $prodi = Prodi::where('nama_prodi', $prodiName)->first();
            $this->prodiCache[$prodiName] = $prodi ? $prodi->id : null;
        }

        return $this->prodiCache[$prodiName];
    }

    private function handleTahunKeluar($tahunKeluar, $status)
    {
        if ($status === 'Lulus' && !empty($tahunKeluar)) {
            return $tahunKeluar;
        }
        return null;
    }

    private function formatNim($nim)
    {
        // Handle semua kemungkinan format NIM
        if ($nim === null || $nim === '') {
            return '';
        }

        // Jika float (202301001.0)
        if (is_float($nim)) {
            return (string) intval($nim);
        }
        
        // Jika integer (202301001)
        if (is_int($nim)) {
            return (string) $nim;
        }
        
        // Jika sudah string, return as is
        if (is_string($nim)) {
            return $nim;
        }
        
        // Fallback: convert to string
        return (string) $nim;
    }
}