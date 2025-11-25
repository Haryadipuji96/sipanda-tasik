<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class TemplateBarangRuanganExport implements FromArray, WithHeadings, WithTitle, WithEvents
{
    protected $ruangan;

    public function __construct($ruangan)
    {
        $this->ruangan = $ruangan;
    }

    public function array(): array
    {
        $currentYear = date('Y');
        
        return [
            ["Kursi Kantor", "PERABOTAN & FURNITURE", "IKEA", 500000, 2, "unit", "Baik", "2024-01-15", $currentYear, "LEMBAGA", "Kursi kantor ergonomis", "KRS-001", "", "Untuk ruang staff"],
            ["Laptop ASUS", "ELEKTRONIK & TEKNOLOGI", "ASUS", 8000000, 1, "unit", "Baik Sekali", "2024-02-20", $currentYear, "HIBAH", "ASUS Vivobook 15, Intel i5, 8GB RAM", "LAP-001", "", "Untuk laboratorium"],
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'nama_barang*',
            'kategori_barang*',
            'merk_barang',
            'harga_rp',
            'jumlah*',
            'satuan*',
            'kondisi*',
            'tanggal_pengadaan',
            'tahun_pengadaan',
            'sumber_barang*',
            'spesifikasi*',
            'kodeseri_barang*',
            'lokasi_lain',
            'keterangan'
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
                
                // ========== DROPDOWN KATEGORI BARANG ==========
                $kategoriOptions = [
                    'PERABOTAN & FURNITURE',
                    'ELEKTRONIK & TEKNOLOGI', 
                    'PERALATAN LABORATORIUM',
                    'PERALATAN KANTOR',
                    'ALAT KOMUNIKASI',
                    'LAINNYA'
                ];
                
                $validation = $sheet->getDataValidation('B2:B100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $kategoriOptions) . '"');

                // ========== DROPDOWN SATUAN ==========
                $satuanOptions = ['unit', 'buah', 'set', 'lusin', 'paket'];
                
                $validation = $sheet->getDataValidation('F2:F100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $satuanOptions) . '"');

                // ========== DROPDOWN KONDISI ==========
                $kondisiOptions = ['Baik Sekali', 'Baik', 'Cukup', 'Rusak Ringan', 'Rusak Berat'];
                
                $validation = $sheet->getDataValidation('G2:G100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $kondisiOptions) . '"');

                // ========== DROPDOWN SUMBER BARANG ==========
                $sumberOptions = ['HIBAH', 'LEMBAGA', 'YAYASAN'];
                
                $validation = $sheet->getDataValidation('J2:J100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $sumberOptions) . '"');

                // ========== STYLING ==========
                $sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']]
                ]);

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(25); // nama_barang
                $sheet->getColumnDimension('B')->setWidth(25); // kategori_barang
                $sheet->getColumnDimension('K')->setWidth(35); // spesifikasi
                $sheet->getColumnDimension('L')->setWidth(20); // kodeseri_barang
            },
        ];
    }
}