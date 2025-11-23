<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateMahasiswaExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Template' => new TemplateSheet(),
            'Panduan' => new GuideSheet(),
        ];
    }
}

class TemplateSheet implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $prodiId;
    protected $prodiName;

    public function __construct()
    {
        $prodi = \App\Models\Prodi::first();
        $this->prodiId = $prodi ? $prodi->id : 1;
        $this->prodiName = $prodi ? $prodi->nama_prodi : 'Default Prodi';
    }

    public function array(): array
    {
        $currentYear = date('Y');
        
        return [
            ["202301001", 'Ahmad Fauzi', $this->prodiId, 'Aktif', $currentYear, ''],
            ["202301002", 'Siti Rahayu', $this->prodiId, 'Lulus', $currentYear, $currentYear],
            ["202301003", 'Budi Santoso', $this->prodiId, 'Aktif', $currentYear, ''],
            ['', '', $this->prodiId, '', '', ''],
            ['', '', $this->prodiId, '', '', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'nim*',
            'nama_lengkap*', 
            'program_studi_id*',
            'status_mahasiswa*',
            'tahun_masuk*',
            'tahun_keluar'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']]
            ],
            'A2:F4' => [
                'font' => ['color' => ['rgb' => '666666']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F4F6']]
            ],
            // Note untuk prodi_id
            'C1' => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FEF3CD']]
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, 'B' => 25, 'C' => 20, 'D' => 20, 'E' => 15, 'F' => 15,
        ];
    }

    public function title(): string
    {
        return 'Template';
    }
}

class GuideSheet implements FromArray, WithStyles, WithColumnWidths, WithTitle
{
    protected $prodiId;
    protected $prodiName;

    public function __construct()
    {
        $prodi = \App\Models\Prodi::first();
        $this->prodiId = $prodi ? $prodi->id : 1;
        $this->prodiName = $prodi ? $prodi->nama_prodi : 'Default Prodi';
    }

    public function array(): array
    {
        return [
            ['PANDUAN IMPORT MAHASISWA'],
            [''],
            ['INFORMASI PROGRAM STUDI:'],
            ['• ID Program Studi: ' . $this->prodiId],
            ['• Nama Program Studi: ' . $this->prodiName],
            ['• CATATAN: Gunakan ID ' . $this->prodiId . ' untuk semua data'],
            [''],
            ['KOLOM WAJIB (*):'],
            ['• NIM: Nomor Induk Mahasiswa (teks)'],
            ['• Nama Lengkap: Nama lengkap mahasiswa'],
            ['• Program Studi ID: ' . $this->prodiId . ' (' . $this->prodiName . ')'],
            ['• Status Mahasiswa: Aktif, Lulus, Cuti, atau Drop Out'],
            ['• Tahun Masuk: Tahun masuk (2000-' . (date('Y') + 1) . ')'],
            [''],
            ['KOLOM OPSIONAL:'],
            ['• Tahun Keluar: Hanya diisi jika status = Lulus'],
            [''],
            ['CONTOH FORMAT:'],
            ['NIM: 202301001 (teks, bukan angka)'],
            ['Program Studi ID: ' . $this->prodiId . ' (harus ' . $this->prodiId . ')'],
            ['Status: Aktif/Lulus/Cuti/Drop Out'],
            ['Tahun Masuk: ' . date('Y')],
            ['Tahun Keluar: (kosongkan atau ' . date('Y') . ' untuk status Lulus)'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            3 => ['font' => ['bold' => true, 'color' => ['rgb' => 'DC2626']]],
            9 => ['font' => ['bold' => true]],
            16 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 60,
        ];
    }

    public function title(): string
    {
        return 'Panduan';
    }
}