<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TemplateMahasiswaExport implements FromArray, WithHeadings, WithTitle, WithEvents
{
    protected $prodiList;

    public function __construct()
    {
        $this->prodiList = \App\Models\Prodi::all();
    }

    public function array(): array
    {
        $currentYear = date('Y');
        $firstProdi = $this->prodiList->first();
        
        return [
            ["202301001", 'Ahmad Fauzi', $firstProdi ? $firstProdi->nama_prodi : '', 'Aktif', $currentYear, ''],
            ["202301002", 'Siti Rahayu', $firstProdi ? $firstProdi->nama_prodi : '', 'Lulus', $currentYear, $currentYear],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'nim*',
            'nama_lengkap*', 
            'program_studi*',
            'status_mahasiswa*',
            'tahun_masuk*',
            'tahun_keluar'
        ];
    }

    public function title(): string
    {
        return 'Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // ========== FORCE NIM AS TEXT ==========
                $sheet->getStyle('A2:A100')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);
                
                // ========== DROPDOWN PROGRAM STUDI ==========
                $prodiOptions = $this->prodiList->pluck('nama_prodi')->toArray();
                $dropdownOptions = '"' . implode(',', $prodiOptions) . '"';
                
                $validation = $sheet->getDataValidation('C2:C100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1($dropdownOptions);

                // ========== DROPDOWN STATUS MAHASISWA ==========
                $statusOptions = ['Aktif', 'Lulus', 'Cuti', 'Drop Out'];
                $statusDropdown = '"' . implode(',', $statusOptions) . '"';
                
                $validation = $sheet->getDataValidation('D2:D100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1($statusDropdown);

                // ========== STYLING ==========
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']]
                ]);
            },
        ];
    }
}