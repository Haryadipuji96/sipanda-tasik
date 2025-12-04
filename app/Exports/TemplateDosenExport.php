<?php

namespace App\Exports;

use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;

class TemplateDosenExport implements FromArray, WithHeadings, WithTitle, WithEvents
{
    protected $prodiList;

    public function __construct()
    {
        $this->prodiList = Prodi::all();
    }

    public function array(): array
    {
        $firstProdi = $this->prodiList->first();
        
        return [
            [
                $firstProdi ? $firstProdi->nama_prodi : '', // program_studi
                'Dr.', // gelar_depan
                'Ahmad Fauzi', // nama
                'M.Kom.', // gelar_belakang
                'Jakarta', // tempat_lahir
                '1990-05-15', // tanggal_lahir
                '202302094', // nik
                '1234567890123456', // nuptk
                'S2', // pendidikan_terakhir
                'Lektor', // jabatan
                '2015-08-01', // tmt_kerja
                '8', // masa_kerja_tahun
                '3', // masa_kerja_bulan
                'IV/a', // pangkat_golongan
                'Lektor', // jabatan_fungsional
                'IV/a', // golongan
                '5', // masa_kerja_golongan_tahun
                '2', // masa_kerja_golongan_bulan
                '123/SK/2023', // no_sk
                '456/SK-JF/2023', // no_sk_jafung
                'DOSEN_TETAP', // status_dosen
                'SUDAH', // sertifikasi
                'BELUM', // inpasing
                '2010;S1|2015;S2|2020;S3' // riwayat_pendidikan
            ],
            [
                $firstProdi ? $firstProdi->nama_prodi : '',
                'Ir.',
                'Budi Santoso',
                'M.T., M.Sc.',
                'Bandung',
                '1985-10-25',
                '202302095',
                '2345678901234567',
                'S3',
                'Guru Besar',
                '2010-03-15',
                '13',
                '6',
                'IV/e',
                'Guru Besar',
                'IV/e',
                '10',
                '4',
                '789/SK/2022',
                '012/SK-JF/2022',
                'PNS',
                'SUDAH',
                'SUDAH',
                '2005;S1|2010;S2|2015;S3'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'program_studi*',
            'gelar_depan',
            'nama*',
            'gelar_belakang',
            'tempat_lahir',
            'tanggal_lahir',
            'nik',
            'nuptk',
            'pendidikan_terakhir',
            'jabatan',
            'tmt_kerja',
            'masa_kerja_tahun',
            'masa_kerja_bulan',
            'pangkat_golongan',
            'jabatan_fungsional',
            'golongan',
            'masa_kerja_golongan_tahun',
            'masa_kerja_golongan_bulan',
            'no_sk',
            'no_sk_jafung',
            'status_dosen*',
            'sertifikasi*',
            'inpasing*',
            'riwayat_pendidikan'
        ];
    }

    public function title(): string
    {
        return 'Template Dosen';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set column widths
                $columns = [
                    'A' => 25, 'B' => 15, 'C' => 25, 'D' => 20, 'E' => 20,
                    'F' => 15, 'G' => 15, 'H' => 20, 'I' => 20, 'J' => 20,
                    'K' => 15, 'L' => 20, 'M' => 20, 'N' => 20, 'O' => 25,
                    'P' => 15, 'Q' => 20, 'R' => 20, 'S' => 20, 'T' => 20,
                    'U' => 20, 'V' => 15, 'W' => 15, 'X' => 35
                ];
                
                foreach ($columns as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }
                
                // Format NIK and NUPTK as text
                $sheet->getStyle('G2:G100')->getNumberFormat()->setFormatCode('@');
                $sheet->getStyle('H2:H100')->getNumberFormat()->setFormatCode('@');
                
                // Dropdown for program studi
                $prodiOptions = $this->prodiList->pluck('nama_prodi')->toArray();
                $prodiValidation = new DataValidation();
                $prodiValidation->setType(DataValidation::TYPE_LIST);
                $prodiValidation->setErrorStyle(DataValidation::STYLE_STOP);
                $prodiValidation->setAllowBlank(false);
                $prodiValidation->setShowInputMessage(true);
                $prodiValidation->setShowErrorMessage(true);
                $prodiValidation->setShowDropDown(true);
                $prodiValidation->setFormula1('"' . implode(',', $prodiOptions) . '"');
                
                for ($row = 2; $row <= 100; $row++) {
                    $sheet->getCell("A{$row}")->setDataValidation(clone $prodiValidation);
                }
                
                // Dropdown for status dosen
                $statusValidation = new DataValidation();
                $statusValidation->setType(DataValidation::TYPE_LIST);
                $statusValidation->setErrorStyle(DataValidation::STYLE_STOP);
                $statusValidation->setAllowBlank(false);
                $statusValidation->setShowInputMessage(true);
                $statusValidation->setShowErrorMessage(true);
                $statusValidation->setShowDropDown(true);
                $statusValidation->setFormula1('"DOSEN_TETAP,DOSEN_TIDAK_TETAP,PNS"');
                
                for ($row = 2; $row <= 100; $row++) {
                    $sheet->getCell("U{$row}")->setDataValidation(clone $statusValidation);
                }
                
                // Dropdown for sertifikasi
                $sertifikasiValidation = new DataValidation();
                $sertifikasiValidation->setType(DataValidation::TYPE_LIST);
                $sertifikasiValidation->setErrorStyle(DataValidation::STYLE_STOP);
                $sertifikasiValidation->setAllowBlank(false);
                $sertifikasiValidation->setShowInputMessage(true);
                $sertifikasiValidation->setShowErrorMessage(true);
                $sertifikasiValidation->setShowDropDown(true);
                $sertifikasiValidation->setFormula1('"SUDAH,BELUM"');
                
                for ($row = 2; $row <= 100; $row++) {
                    $sheet->getCell("V{$row}")->setDataValidation(clone $sertifikasiValidation);
                }
                
                // Dropdown for inpasing
                $inpasingValidation = new DataValidation();
                $inpasingValidation->setType(DataValidation::TYPE_LIST);
                $inpasingValidation->setErrorStyle(DataValidation::STYLE_STOP);
                $inpasingValidation->setAllowBlank(false);
                $inpasingValidation->setShowInputMessage(true);
                $inpasingValidation->setShowErrorMessage(true);
                $inpasingValidation->setShowDropDown(true);
                $inpasingValidation->setFormula1('"SUDAH,BELUM"');
                
                for ($row = 2; $row <= 100; $row++) {
                    $sheet->getCell("W{$row}")->setDataValidation(clone $inpasingValidation);
                }
                
                // Style header
                $sheet->getStyle('A1:X1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                ]);
                
                $sheet->getRowDimension(1)->setRowHeight(30);
                
                // Highlight required columns
                $requiredColumns = ['A', 'C', 'U', 'V', 'W'];
                foreach ($requiredColumns as $column) {
                    $sheet->getStyle($column . '1')->getFont()->getColor()->setARGB(Color::COLOR_YELLOW);
                }
                
                // Style example data
                $sheet->getStyle('A2:X3')->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                ]);
                
                // Add notes
                $noteRow = 5;
                $sheet->setCellValue("A{$noteRow}", 'CATATAN PENTING:');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '1. Kolom dengan tanda * wajib diisi');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '2. Format tanggal: YYYY-MM-DD (contoh: 1990-05-15)');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '3. Status Dosen: DOSEN_TETAP, DOSEN_TIDAK_TETAP, atau PNS');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '4. Sertifikasi & Inpasing: SUDAH atau BELUM');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '5. Riwayat Pendidikan format: tahun;jenjang|tahun;jenjang');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '6. Contoh: 2010;S1|2015;S2|2020;S3');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '7. Masa kerja bulan maksimal 11');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '8. NIK dan NUPTK sudah diformat sebagai teks');
                $noteRow++;
                $sheet->setCellValue("A{$noteRow}", '9. Hapus baris contoh sebelum mengisi data');
                
                // Style notes
                $sheet->getStyle("A5:A" . $noteRow)->getFont()->setBold(true);
                
                // Freeze header
                $sheet->freezePane('A2');
            },
        ];
    }
}