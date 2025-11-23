<?php

namespace App\Imports;

use App\Models\DokumenMahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class DokumenMahasiswaImport extends DefaultValueBinder implements ToModel, WithHeadingRow, WithValidation, WithCustomValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        // Force NIM column to be treated as text
        if ($cell->getColumn() === 'A' && $cell->getRow() >= 2) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function model(array $row)
    {
        // Convert NIM to string and remove any decimal points
        $nim = $this->formatNim($row['nim']);
        
        return new DokumenMahasiswa([
            'nim' => $nim,
            'nama_lengkap' => $row['nama_lengkap'],
            'prodi_id' => $row['program_studi_id'] ?? $row['prodi_id'],
            'status_mahasiswa' => $row['status_mahasiswa'],
            'tahun_masuk' => $row['tahun_masuk'],
            'tahun_keluar' => $this->handleTahunKeluar($row['tahun_keluar'] ?? null, $row['status_mahasiswa']),
        ]);
    }

    public function rules(): array
    {
        $currentYear = date('Y');
        
        return [
            'nim' => 'required|string|max:20|unique:dokumen_mahasiswa,nim',
            'nama_lengkap' => 'required|string|max:255',
            'program_studi_id' => 'required|exists:prodi,id',
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
            'nim.string' => 'NIM harus berupa teks',
            'nim.unique' => 'NIM sudah digunakan',
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'program_studi_id.required' => 'Program Studi ID harus diisi',
            'program_studi_id.exists' => 'Program Studi ID tidak valid',
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

    private function handleTahunKeluar($tahunKeluar, $status)
    {
        // Only set tahun_keluar if status is Lulus and value is provided
        if ($status === 'Lulus' && !empty($tahunKeluar)) {
            return $tahunKeluar;
        }
        return null;
    }

    private function formatNim($nim)
    {
        // Handle various NIM formats
        if (is_numeric($nim)) {
            // Remove decimal points and convert to string
            return (string) intval($nim);
        }
        
        // If already string, just return it
        return (string) $nim;
    }
}